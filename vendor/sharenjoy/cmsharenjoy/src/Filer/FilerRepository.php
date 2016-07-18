<?php namespace Sharenjoy\Cmsharenjoy\Filer;

use Illuminate\Support\Str;
use Cartalyst\Sentry\Users\Eloquent\User;
use Sharenjoy\Cmsharenjoy\Utilities\CmsharenjoyString;
use Config, Setting, Session, Image;

/**
 * PyroCMS File library.
 *
 * This handles all file manipulation
 * both locally and in the cloud
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Files\Libraries
 */
class FilerRepository implements FilerInterface {

    public		$providers;
    public      $path;
    public 		$thumbPath;
    public		$max_size_possible;
    public		$max_size_allowed;
    protected	$_cache_path;
    protected 	$_ext;
    protected	$_type = '';
    protected	$_filename = null;
    protected	$_mimetype;

    // ------------------------------------------------------------------------

    public function __construct()
    {
        $this->path        = public_path().Config::get('filer.path');
        $this->thumbPath   = public_path().Config::get('filer.thumbPath');
        $this->_cache_path = public_path().Config::get('filer.cache_path');

        if ($providers = Setting::get('files_enabled_providers')) {
            $this->providers = explode(',', $providers);

            // make 'local' mandatory. We search for the value because of backwards compatibility
            if ( ! in_array('local', $this->providers)) {
                array_unshift($this->providers, 'local');
            }
        } else {
            $this->providers = array('local');
        }

        // work out the most restrictive ini setting
        $post_max = str_replace('M', '', ini_get('post_max_size'));
        $file_max = str_replace('M', '', ini_get('upload_max_filesize'));
        // set the largest size the server can handle and the largest the admin set
        // sould be post_max_size > upload_max_filesize
        $this->max_size_possible = ($file_max > $post_max ? $post_max : $file_max) * 1048576; // convert to bytes
        $this->max_size_allowed = Setting::get('files_upload_limit') * 1048576; // convert this to bytes also

        set_exception_handler(array($this, 'exceptionHandler'));
        set_error_handler(array($this, 'errorHandler'));
    }

    public function getMaxSizePossible()
    {
        return $this->max_size_possible;
    }

    public function getMaxSizeAllowed()
    {
        return $this->max_size_allowed;
    }

    // ------------------------------------------------------------------------

    /**
     * Create an empty folder
     *
     * @param	int		$parent	The id of this folder's parent
     * @param	string	$name	Desired Name. If left empty a name will be assigned
     * @return	array
     *
    **/
    public function createFolder($parent = 0, $name = 'Untitled Folder', $location = 'local', $remote_container = '', $hidden = 0)
    {
        $original_slug = $this->createSlug($name);
        $original_name = $name;

        $slug = $original_slug;

        $i = 0;
        while (Folder::findBySlug($slug)->count()) {
            ++$i;
            $slug = $original_slug.'-'.$i;
            // $name = $original_name.'-'.$i;
        }

        $folder = Folder::create(array(
            'parent_id' => $parent,
            'slug' => $slug,
            'name' => $name,
            'location' => $location,
            'remote_container' => $remote_container,
            'sort' => time(),
            'hidden' => $hidden,
        ));

        $insert['id'] = $folder->id;
        $insert['file_count'] = 0;
        $insert['name'] = $folder->name;

        return $this->result(true, trans('files.item_created'), $insert['name'], $folder->toArray());
    }

    // ------------------------------------------------------------------------

    /**
     * Create a container with the cloud provider
     *
     * @param	string	$container	Container name
     * @param	string	$location	The cloud provider
     * @return	array
     *
    **/
    public function createContainer($container, $location, $id = 0)
    {
        ci()->storage->load_driver($location);

        $result = ci()->storage->create_container($container, 'public');

        // if they are also linking a local folder then we save that
        if ($id) {
            $folder = Folder::find($id);
            $folder->remote_container = $container;
            $folder->save();
        }

        if ($result) {
            return $this->result(true, trans('files.container_created'), $container);
        }

        return $this->result(false, trans('files.error_container'), $container);
    }

    // ------------------------------------------------------------------------

    /**
     * Get all folders and files within a folder
     *
     * @param	int		$parent	The id of this folder
     * @return	array
     *
    **/
    public function folderContents($parent = 0)
    {
        // ci()->load->library('keywords/Keywords');

        // they can also pass a url hash such as #foo/bar/some-other-folder-slug
        if ( ! is_numeric($parent)) {
            $segment = explode('/', trim($parent, '/#'));
            $result = Folder::findBySlug(array_pop($segment))->first();

            $parent = ($result ? $result->id : 0);
        }

        $folders = Folder::findByParentBySort($parent)->toArray();

        $files = File::findByFolderIdBySort($parent)->toArray();

        // let's be nice and add a date in that's formatted like the rest of the CMS
        if ($folders) {
            foreach ($folders as &$folder) {
                $folder['file_count'] = File::findByFolderId($folder->id)->count();
            }
        }

        if ($files) {
            foreach ($files as &$file) {
                $file['keywords_hash'] = $file->keywords;
                // $file['keywords'] = ci()->keywords->get_string($file->keywords);
            }
        }

        return $this->result(true, null, null, array('folder' => $folders, 'file' => $files, 'parent_id' => $parent));
    }

    // ------------------------------------------------------------------------

    /**
     * @param	int		$parent	The id of this folder
     * @return	array
     *
    **/

    /**
     * Get all folders in a tree
     *
     * @return array
     */
    public function folderTree()
    {
        $folders = $folder_array = array();

        $all_folders = Folder::findAllOrdered();

        // we must reindex the array first
        foreach ($all_folders->toArray() as $row) {
            $folders[$row['id']] = (array) $row;
        }

        unset($tree);
        // build a multidimensional array of parent > children
        foreach ($folders as $row) {
            if (array_key_exists($row['parent_id'], $folders)) {
                // add this folder to the children array of the parent folder
                $folders[$row['parent_id']]['children'][] =& $folders[$row['id']];
            }

            // this is a root folder
            if ($row['parent_id'] == 0) {
                $folder_array[] =& $folders[$row['id']];
            }
        }
        return $folder_array;
    }

    // ------------------------------------------------------------------------

    /**
     * Check if an unindexed container exists in the cloud
     *
     * @param	string	$name		The container name
     * @param	string	$location	Amazon/Rackspace
     * @return	array
     *
    **/
    public function checkContainer($name, $location)
    {
        ci()->storage->load_driver($location);

        $containers = ci()->storage->list_containers();

        foreach ($containers as $container) {
            if ($name === $container) {
                return $this->result(true, trans('files.container_exists'), $name);
            }
        }
        return $this->result(false, trans('files.container_not_exists'), $name);
    }

    // ------------------------------------------------------------------------

    /**
     * Rename a folder
     *
     * @param	int		$id		The id of the folder
     * @param	string	$name	The new name
     * @return	array
     *
    **/
    public function renameFolder($id = 0, $name)
    {
        $i = '';
        $original_slug = $this->createSlug($name);
        $original_name = $name;

        $slug = $original_slug;

        while (Folder::findBySlugAndNotId($slug,$id)->count()) {
            $i++;
            $slug = $original_slug.'-'.$i;
            $name = $original_name.'-'.$i;
        }

        $folder = Folder::find($id);
        $folder->slug = $slug;
        $folder->name = $name;
        $folder->save();

        return $this->result(true, trans('files.item_updated'), $folder->name, $folder->toArray());
    }

    // ------------------------------------------------------------------------

    /**
     * Delete an empty folder
     *
     * @param	int		$id		The id of the folder
     * @return	array
     *
    **/
    public function deleteFolder($id = 0)
    {
        $folder = Folder::find($id);

        if ( File::findByFolder($id)->isEmpty() and Folder::findByParent($id)->isEmpty()) {
            $folder->delete($id);

            return $this->result(
                true,
                trans('files.folder_deleted', ['name'=>$folder->name]),
                $folder->name
            );

        } else {
            return $this->result(
                false,
                trans('files.folder_not_empty', ['name'=>$folder->name]),
                $folder->name
            );
        }
    }

    /**
     * Delete an folder and inside of files
     *
     * @param   int     $id     The id of the folder
     * @return  array
     *
    **/
    public function deleteFolderDoNotConfirm($id = 0)
    {
        $folder = Folder::find($id);
        
        $files = File::findByFolder($id);

        foreach ($files as $value)
        {
            $this->deleteFile($value->id);
        }

        $folder->delete($id);

        return $this->result(true, trans('files.item_deleted'), $folder->name);
    }

    /**
     * Upload a file
     *
     * @param int $folder_id The folder to upload it to
     * @param bool $name The filename
     * @param string $field Like CI this defaults to "userfile"
     * @param bool $width The width to resize the image to
     * @param bool $height The height to resize the image to
     * @param bool $ratio Keep the aspect ratio or not?
     * @param string $alt "alt" attribute, here so that it may be set when photos are initially uploaded
     * @param array $allowed types
     * @return array|bool
     */
    public function upload($folder_id, $name = false, $field = 'userfile', $width = false, $height = false, $ratio = false, $allowed_types = false, $alt = NULL, $replace_file = false)
    {
        if ( ! $check_dir = $this->checkDir($this->path)) {
            return $check_dir;
        }

        if ( ! $check_cache_dir = $this->checkDir($this->_cache_path)) {
            return $check_cache_dir;
        }

        if ( ! $check_ext = $this->_checkExt($field)) {
            return $check_ext;
        }

        // this keeps a long running upload from stalling the site
        session_write_close();

        $folder = Folder::find($folder_id);

        if ($folder) {

            list($image_width, $image_height) = getimagesize($field);

            $file_size          = $field->getClientSize();
            $file_mimetype      = $field->getMimeType();
            $file_extension     = $field->getClientOriginalExtension();
            $file_original_name = str_replace(array($file_extension, '.'), '', $field->getClientOriginalName());
            $file_name          = $replace_file ? $replace_file->filename : $this->_filename;
            $full_file_name     = $file_name.'.'.$file_extension;

            if ($field->move($this->path, $full_file_name)) {

                $user = Session::get('user');

                $data = array(
                    'folder_id'		=> $folder_id,
                    'user_id'		=> $user['id'],
                    'type'			=> $this->_type,
                    'name'			=> $file_original_name,
                    'path'			=> '{site}/uploads/large/'.$file_name,
                    'description'	=> $replace_file ? $replace_file->description : '',
                    'alt_attribute'	=> trim($replace_file ? $replace_file->alt_attribute : $alt),
                    'filename'		=> $replace_file ? $replace_file->name : $name ? $name : $file_name,
                    'extension'		=> $file_extension,
                    'mimetype'		=> $file_mimetype,
                    'filesize'		=> $file_size,
                    'width'			=> $image_width,
                    'height'		=> $image_height,
                );

                // create
                $file = File::create($data);
                $file->sort = $file->id;
                $file_id = $file->id;
                $file->save();

                // resizing an uploaded file
                if ($this->_type == 'i')
                {
                    Image::make($this->path.'/'.$full_file_name)
                        ->fit(75, 50)
                        ->save($this->thumbPath.'/'.$full_file_name);
                }
                

                if ($folder->location !== 'local') {
                    header("Connection: close");

                    return Files::move($file_id, $data['filename'], 'local', $folder->location, $folder->remote_container);
                }

                header("Connection: close");

                return $this->result(true, trans('files.file_uploaded'), $data['name'], array('id' => $file_id) + $data);
            }
            else 
            {
                header("Connection: close");
                return $this->result(false, trans('files.upload_error'));
            }
        }
        else
        {
            header("Connection: close");
            return $this->result(false, trans('files.specify_valid_folder'));
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Rename files on the local filesystem or in the cloud
     *
     * @param	string	$file_id		The file's database record
     * @param	string	$new_file		The desired filename
     * @param	string	$location		Its current location, except in the case of an upload this will be found from the db
     * @param	string	$new_location	The desired provider to move the file to
     * @param	string	$container		The bucket, container, or folder to move the file to
     * @return	array
    **/
    public function move($file_id, $new_name = false, $location = false, $new_location = 'local', $container = '')
    {
        $file = File::find($file_id);

        $local_filename = $file->filename;

        if (! $file) {
            return $this->result(false, trans('files.item_not_found'), $new_name ? $new_name : $file_id);
        }

        // this keeps a long running transaction from stalling the site
        session_write_close();

        // this would be used when move() is used during a rackspace or amazon upload as the location in the
        // database is not the actual file location, its location is local temporarily
        if ($location) $file->folder->location = $location;

        // if both locations are on the local filesystem then we just rename
        if ($file->folder->location === 'local' and $new_location === 'local') {
            // if they were helpful enough to provide an extension then remove it
            $file_slug = $this->createSlug(str_replace($file->extension, '', $new_name));
            $filename = $file_slug.$file->extension;

            // does the source exist?
            if (file_exists($this->path.$file->filename)) {
                $i = 1;

                // create a unique filename if the target already exists
                while (file_exists($this->path.$filename)) {
                    // Example: test-image2.jpg
                    $filename = $file_slug.$i.$file->extension;
                    $i++;
                }

                $data = array('id' => $file_id,
                              'name' => $new_name,
                              'filename' => $filename,
                              'location' => $new_location,
                              'container' => $container);

                $file->filename = $filename;
                $file->name = $new_name;
                $file->save();

                @rename($this->path.$file->filename, $this->path.$filename);

                return $this->result(true, trans('files.item_updated'), $new_name, $data);
            } else {
                return $this->result(false, trans('files.item_not_found'), $file->name);
            }
        } elseif ($file->folder->location === 'local' and $new_location) {
            // we'll be pushing the file from here to the cloud
            ci()->storage->load_driver($new_location);

            $containers = ci()->storage->list_containers();

            // if we try uploading to a non-existant container it gets ugly
            if (in_array($container, $containers)) {
                // make a unique object name
                $object = now().'.'.$new_name;

                $path = ci()->storage->upload_file($container, $this->path.$file->filename, $object, null, 'public');

                if ($new_location === 'amazon-s3') {
                    // if amazon didn't throw an error we'll create a path to store like rackspace does
                    $url = ci()->parser->parse_string(Setting::get('files_s3_url'), array('bucket'=> $container), true);
                    $path = rtrim($url, '/').'/'.$object;
                }

                // save its location
                $file->filename = $object;
                $file->path = $path;
                $file->save();

                $data = array('filename' => $object, 'path' => $path);

                // now we create a thumbnail of the image for the admin panel to display
                if ($file->type == 'i') {
                    ci()->load->library('image_lib');

                    $config['image_library']    = 'gd2';
                    $config['source_image']     = $this->path.$file->filename;
                    $config['new_image']        = $this->_cache_path.$data['filename'];
                    $config['maintain_ratio']	= false;
                    $config['width']            = 75;
                    $config['height']           = 50;
                    ci()->image_lib->initialize($config);
                    ci()->image_lib->resize();
                }

                // get rid of the "temp" file
                @unlink($this->path.$file->filename);
                @unlink($this->path.$local_filename);

                $extra_data = array('id' => $file_id,
                    'name' => $new_name,
                    'location' => $new_location,
                    'container' => $container);

                return $this->result(true, trans('files.file_uploaded'), $new_name, $extra_data + $data);
            }

            return $this->result(false, trans('files.invalid_container'), $container);
        } elseif ($file->folder->location and $new_location === 'local') {
            // pull it from the cloud to our filesystem
            ci()->load->helper('file');
            ci()->load->spark('curl/1.2.1');

            // download the file... dum de dum
            $curl_result = ci()->curl->simple_get($file->path);

            if ($curl_result) {
                // if they were helpful enough to provide an extension then remove it
                $file_slug = $this->createSlug(str_replace($file->extension, '', $new_name));
                $filename = $file_slug.$file->extension;

                // create a unique filename if the target already exists
                $i = 0;
                while (file_exists($this->path.$filename)) {
                    // Example: test-image2.jpg
                    $filename = $file_slug.$i.$file->extension;
                    $i++;
                }

                // ...now save it
                write_file($this->path.$filename, $curl_result, 'wb');

                $data = array('id' => $file_id,
                    'name' => $new_name,
                    'location' => $new_location,
                    'container' => $container);

                return $this->result(true, trans('files.file_moved'), $file->name, $data);
            } else {
                return $this->result(false, trans('files.unsuccessful_fetch'), $file);
            }
        } elseif ($file->folder->location and $new_location) {
            // pulling from the cloud and then pushing to another part of the cloud :P
            ci()->load->helper('file');
            ci()->storage->load_driver($new_location);

            // make a really random temp file name
            $temp_file = $this->path.md5(microtime()).'_temp_'.$new_name;

            // and we download...
            $curl_result = ci()->curl->simple_get($file);

            if ($curl_result) {
                write_file($temp_file, $curl_result, 'wb');
            } else {
                return $this->result(false, trans('files.unsuccessful_fetch'), $file);
            }

            // make a unique object name
            $object = now().'.'.$new_name;

            $path = ci()->storage->upload_file($container, $temp_file, $object, null, 'public');

            if ($new_location === 'amazon-s3') {
                // if amazon didn't throw an error we'll create a path to store like rackspace does
                $url = ci()->parser->parse_string(Setting::get('files_s3_url'), array('bucket'=> $container), true);
                $path = rtrim($url, '/').'/'.$object;
            }

            $data = array('filename' => $object, 'path' => $path);

            $file->filename = $object;
            $file->path = path;
            $file->save();

            // get rid of the "temp" file
            @unlink($temp_file);

            $extra_data = array('id' => $file_id,
                'name' => $new_name,
                'location' => $new_location,
                'container' => $container);

            return $this->result(true, trans('files.file_moved'), $file->name, $extra_data + $data);
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Get A Single File
     *
     * @param	int		$identifier	The id or filename
     * @return	array
     *
    **/
    public function getFile($identifier = 0)
    {
        // they could have specified the row id or the actual filename
        $results = strlen($identifier) !== 30 ?
                    File::find($identifier)->toArray() :
                    File::findByFilename($identifier)->toArray();

        //Make sure other code that uses this uses $file->folder->slug instead of $file->folder_slug (and same for folder name)

        $message = $results ? null : trans('files.no_records_found');

        return $this->result( (bool) $results, $message, null, $results);
    }

    // ------------------------------------------------------------------------

    /**
     * Get Known Files
     *
     * @param	string	$location	The cloud provider or local
     * @param	string	$container	The container or folder to get files from
     * @return	array
     *
    **/
    public function getFiles($location = 'local', $container = '')
    {
        $results = File::findBySlugAndLocation($container, $location);
        //Make sure other code that uses this uses $file->folder->slug instead of $file->folder_slug (and same for folder name)

        $message = $results ? null : trans('files.no_records_found');

        return $this->result( (bool) $results, $message, null, $results);
    }

    // ------------------------------------------------------------------------

    /**
     * List Files -- get_files() returns database records. This pulls from
     * the cloud instead but for completeness it will fetch local file names
     * from the database if the location is "local"
     *
     * @param	string	$location	The cloud provider or local
     * @param	string	$container	The container or folder to list files from
     * @return	array
     *
    **/
    public function listFiles($location = 'local', $container = '')
    {
        $i = 0;
        $files = array();

        // yup they want real live file names from the cloud
        if ($location !== 'local' and $container) {
            ci()->storage->load_driver($location);

            $cloud_list = ci()->storage->list_files($container);

            if ($cloud_list) {
                foreach ($cloud_list as $value) {
                    $this->_getFileInfo($value['name']);

                    if ($location === 'amazon-s3') {
                        // we'll create a path to store like rackspace does
                        $url = ci()->parser->parse_string(Setting::get('files_s3_url'), array('bucket'=> $container), true);
                        $path = rtrim($url, '/').'/'.$value['name'];
                    } elseif ($location === 'rackspace-cf') {
                        // fetch the cdn uri from Rackspace
                        $cf_container = ci()->storage->get_container($container);
                        $path = $cf_container['cdn_uri'];

                        // they are trying to index a non-cdn enabled container
                        if (! $cf_container['cdn_enabled']) {
                            // we'll try to enable it for them
                            if ( ! $path = ci()->storage->create_container($container, 'public')) {
                                // epic fails all around!!
                                return $this->result(false, trans('files.enable_cdn'), $container);
                            }
                        }
                        $path = rtrim($path, '/').'/'.$value['name'];
                    }

                    $files[$i]['filesize'] 		= ((int) $value['size']) / 1000;
                    $files[$i]['filename'] 		= $value['name'];
                    $files[$i]['extension']		= $this->_ext;
                    $files[$i]['type']			= $this->_type;
                    $files[$i]['mimetype']		= $this->_mimetype;
                    $files[$i]['path']			= $path;
                    $files[$i]['date_added']	= $value['time'];
                    $i++;
                }
            }
        } elseif ($location === 'local') {
             // they're wanting a local list... give it to 'em but only if the file really exists
            $results = File::findBySlug($container);

            if ($results) {
                foreach ($results as $value) {
                    if (file_exists($this->path.$value->filename)) {
                        $files[$i]['filesize'] 		= $value->filesize;
                        $files[$i]['filename'] 		= $value->filename;
                        $files[$i]['extension']		= $value->extension;
                        $files[$i]['type']			= $value->type;
                        $files[$i]['mimetype']		= $value->mimetype;
                        $files[$i]['path']			= $value->path;
                        $files[$i]['date_added']	= $value->date_added;
                        $i++;
                    }
                }
            }
        }

        $message = $files ? null : trans('files.no_records_found');

        return $this->result( (bool) $files, $message, null, $files);
    }

    // ------------------------------------------------------------------------

    /**
     * Index files from a remote container
     *
     * @param	string	$folder_id	The folder id to refresh. Files will be fetched from its assigned container
     * @return	array
     *
    **/
    public function synchronize($folder_id)
    {
        $folder = Folder::find($folder_id);

        //list of files should be obtainable via files

        $files = Files::listFiles($folder->location, $folder->remote_container);

        // did the fetch go ok?
        if ($files['status']) {
            $valid_records = array();
            $known = array();
            $known_files = File::findByFolderId($folder_id);

            // now we build an array with the database filenames as the keys so we can compare with the cloud list
            foreach ($known_files as $item) {
                $known[$item->filename] = $item;
            }

            foreach ($files['data'] as $file) {
                // it's a totally new file
                if ( ! array_key_exists($file['filename'], $known)) {
                    $insert = array(
                        'id' 			=> substr(md5(microtime()+$data['filename']), 0, 15),
                        'folder_id' 	=> $folder_id,
                        'user_id'		=> ci()->current_user->id,
                        'type'			=> $file['type'],
                        'name'			=> $file['filename'],
                        'filename'		=> $file['filename'],
                        'path'			=> $file['path'],
                        'description'	=> '',
                        'extension'		=> $file['extension'],
                        'mimetype'		=> $file['mimetype'],
                        'filesize'		=> $file['filesize'],
                        'date_added'	=> $file['date_added']
                    );

                    // we add the id to the list of records that have existing files to match them
                    $valid_records[] = File::create($insert);
                } else { // it's totally not a new file
                    // update with the details we got from the cloud
                    File::where('id',$known[$file['filename']]->id)->update($file);

                    // we add the id to the list of records that have existing files to match them
                    $valid_records[] = $known[$file['filename']]->id;
                }
            }

            // Ok then. Let's clean up the records with no files and get out of here
            File::where('folder_id', $folder_id)->whereNotIn('id', $valid_records)->delete();

            return $this->result(true, trans('files.synchronization_complete'), $folder->name, $files['data']);
        } else {
            return $this->result(null, trans('files.no_records_found'));
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Rename a file
     *
     * @param	int		$id		The id of the file
     * @param	string	$name	The new name
     * @return	array
     *
    **/
    public function renameFile($id = 0, $name)
    {
        // physical filenames cannot be changed because of the risk of breaking embedded urls so we just change the db
        File::where('id', $id)->update(array('name' => $name));

        return $this->result(true, trans('files.item_updated'), $name, array('id' => $id, 'name' => $name));
    }

    // ------------------------------------------------------------------------

    /**
     * Delete a file
     *
     * @param	int		$id		The id of the file
     * @return	array
     *
    **/
    public function replaceFile($to_replace, $folder_id, $name = false, $field = 'userfile', $width = false, $height = false, $ratio = false, $allowed_types = false, $alt_attribute = null)
    {
        if ($file_to_replace = File::find($to_replace)) {
            //remove the old file...
            $this->_unlinkFile($file_to_replace);

            //...then upload the new file
            $result = $this->upload($folder_id, $name, $field, $width, $height, $ratio, $allowed_types, $alt_attribute, $file_to_replace);

            // remove files from cache
            if ($result['status'] == 1) {
                //md5 the name like they do it back in the thumb function
                $cached_file_name = md5($file_to_replace->filename) . $file_to_replace->extension;
                $path = Setting::get('cache_dir') . 'image_files/';

                $cached_files = glob( $path . '*_' . $cached_file_name );

                foreach ($cached_files as $full_path) {
                    @unlink($full_path);
                }
            }

            return $result;
        }

        return $this->result(false, trans('files.item_not_found'), $id);
    }

    // ------------------------------------------------------------------------

    /**
     * Delete a file
     *
     * @param	int		$id		The id of the file
     * @return	array
     *
    **/
    public function deleteFile($id = 0)
    {
        if ($file = File::find($id))
        {
            if ($this->_unlinkFile($file))
            {
                $file->delete();

                return $this->result(true, trans('files.item_deleted'), $file->name);
            }
        }

        return $this->result(false, trans('files.item_not_found'), $id);
    }

    // ------------------------------------------------------------------------

    /**
     * Search all files and folders
     *
     * @param	int		$search		The keywords to search for
     * @return	array
     *
    **/
    public function search($search, $limit = 5)
    {
        $results = array();
        $search = explode(' ', $search);

        $results['folder'] = Folder::findByKeywords($search, $limit);
        $results['file'] = File::findByKeywords($search, $limit);

        // search for file by tagged keyword
        $results['tagged'] = ci()->file_m->select('files.*')
            ->limit($limit)
            ->get_tagged($search);

        if ($results['file'] or $results['folder'] or $results['tagged']) {
            return $this->result(true, null, null, $results);
        }

        return $this->result(false, trans('files.no_records_found'));
    }

    // ------------------------------------------------------------------------

    /**
     * Result
     *
     * Return a message in a uniform format for the entire library
     *
     * @param	bool	$status		Operation was a success or failure
     * @param	string	$message	The failure message to return
     * @param	mixed	$args		Arguments to pass to sprint_f
     * @param	mixed	$data		Any data to be returned
     * @return	array
     *
    **/
    public function result($status = true, $message = '', $args = false, $data = '')
    {
        return array('status' 	=> $status,
                     'message' 	=> $args ? sprintf($message, $args) : $message,
                     'data' 	=> $data
                     );
    }

    // ------------------------------------------------------------------------

    /**
     * Permissions
     *
     * Return a simple array of allowed actions
     *
     * @return	array
     *
    **/
    public function allowedActions(User $user)
    {
        if (is_null($user)) {
            throw new InvalidArgumentException('Argument #1 $user cannot be null.');
        }

        return array_map(function($role) use ($user) {

            // build a simplified permission list for use in this module
            if ($user->hasAccess("files.{$role}")) {
                return $role;
            }

        }, ci()->moduleManager->roles('files'));
    }

    // ------------------------------------------------------------------------

    /**
     * Exception Handler
     *
     * Return a the error message thrown by Cloud Files
     *
     * @return	array
     *
    **/
    public function exceptionHandler($e)
    {
        log_message('debug', $e->getMessage());

        echo json_encode(array(
            'status'  => false,
             'message' => $e->getMessage(),
            'data' 	  => ''
         ));
    }

    // ------------------------------------------------------------------------

    /**
     * Error Handler
     *
     * Return the error message thrown by Amazon S3
     *
     * @return	array
     *
    **/
    public function errorHandler($e_number, $error)
    {
        // log_message('debug', $error);

        // only output the S3 error messages
        if (strpos($error, 'S3') !== false) {
            exit(json_encode(array(
                'status'   => false, // clean up the error message to make it more readable
                'message'  => preg_replace('@S3.*?\[.*?\](.*)$@ms', '$1', $error),
                'data' 	   => ''
            )));
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Create Slug
     *
     * Strip all odd characters out of a name and lowercase it
     *
     * @param	string	$name	The uncleaned name string
     * @return	string
     *
    **/
    protected function createSlug($name)
    {
        $name = CmsharenjoyString::slug($name);

        return $name;
    }

    // ------------------------------------------------------------------------

    /**
     * Check our upload directory
     *
     * This is used on the local filesystem
     *
     * @return	bool
     *
    **/
    public function checkDir($path)
    {
        if (is_dir($path) and is_really_writable($path))
        {
            return $this->result(true);
        }
        elseif ( ! is_dir($path))
        {
            if ( ! @mkdir($path, 0777, true))
            {
                return $this->result(false, trans('files.mkdir_error'), $path);
            }
            else
            {
                // create a catch all html file for safety
                $uph = fopen($path . 'index.html', 'w');
                fclose($uph);
            }
        }
        elseif ( ! chmod($path, 0777))
        {
            return $this->result(false, trans('files.chmod_error'));
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Check the extension and clean the file name
     *
     *
     * @return	bool
     *
    **/
    private function _checkExt($field)
    {
        if ( ! empty($field)) {
            $ext     = $field->getClientOriginalExtension();
            $allowed = Config::get('filer.allowed_file_ext');

            foreach ($allowed as $type => $ext_arr) {
                if (in_array(strtolower($ext), $ext_arr)) {
                    $this->_type		= $type;
                    $this->_ext			= implode('|', $ext_arr);
                    $this->_filename	= str_random(30);

                    break;
                }
            }

            if ( ! $this->_ext) {
                return $this->result(false, trans('files.invalid_extension'), $field->getClientOriginalName());
            }
        } else {
            return $this->result(false, trans('files.upload_error'));
        }

        return $this->result(true);
    }

    // ------------------------------------------------------------------------

    /**
     * Get the file type and extension from the name
     *
     *
     * @return	bool
     *
    **/
    private function _getFileInfo($filename)
    {
        ci()->load->helper('file');

        $ext		= array_pop(explode('.', $filename));
        $allowed	= Config::get('files.allowed_file_ext');

        foreach ($allowed as $type => $ext_arr) {
            if (in_array(strtolower($ext), $ext_arr)) {
                $this->_type		= $type;
                $this->_ext			= '.'.$ext;
                $this->_filename	= $filename;
                $this->_mimetype	= get_mime_by_extension($filename);

                break;
            }
        }
    }

    /**
     * Physically delete a file
     *
     * @return	bool
     *
    **/
    private function _unlinkFile($file)
    {
        if ( ! isset($file->filename) ) {
            return false;
        }

        @unlink($this->path.'/'.$file->filename.'.'.$file->extension);

        if ($file->type == 'i')
        {
            @unlink($this->thumbPath.'/'.$file->filename.'.'.$file->extension);
        }

        return true;
    }

    /**
     * Folder Tree
     *
     * Get folder in an array
     *
     * @uses folder_subtree
     */
    public function folderTreeRecursive($parent_id = 0, $depth = 0, &$arr = array())
    {
        $arr = $arr ? $arr : array();

        if ($parent_id === 0) {
            $arr	= array();
            $depth	= 0;
        }

        $folders = Folder::findByParentAndSortByName($parent_id);

        if (! $folders) {
            return $arr;
        }

        $root = null;

        foreach ($folders as $folder) {
            if ($depth < 1) {
                $root = $folder->id;
            }

//			$folder->name_indent		= repeater('&raquo; ', $depth) . $folder->name;
            $folder->root_id			= $root;
            $folder->depth				= $depth;
            $folder->count_files		= count($folder->files);
            $arr[$folder->id]			= $folder;
            $old_size					= sizeof($arr);

            static::folderTreeRecursive($folder->id, $depth+1, $arr);

            $folder->count_subfolders	= sizeof($arr) - $old_size;
        }

        if ($parent_id === 0) {
            foreach ($arr as $id => &$folder) {
                $folder->virtual_path		= static::_buildAscSegments($id, array(
                    'segments'	=> $arr,
                    'separator'	=> '/',
                    'attribute'	=> 'slug'
                ));
            }

            $this->_folders = $arr;
        }

        if ($parent_id > 0 && $depth < 1) {
            foreach ($arr as $id => &$folder) {
                $folder->virtual_path = $this->_folders[$id]->virtual_path;
            }
        }

        return $arr;
    }

    private function _buildAscSegments($id, $options = array())
    {
        if ( ! isset($options['segments'])) {
            return;
        }

        $defaults = array(
            'attribute'	=> 'name',
            'separator'	=> ' &raquo; ',
            'limit'		=> 0
        );

        $options = array_merge($defaults, $options);

        extract($options);

        $arr = array();

        while (isset($segments[$id])) {
            array_unshift($arr, $segments[$id]->{$attribute});
            $id = $segments[$id]->parent_id;
        }

        if (is_int($limit) && $limit > 0 && sizeof($arr) > $limit) {
            array_splice($arr, 1, -($limit-1), '&#8230;');
        }

        return implode($separator, $arr);
    }

    /**
     * Tagged
     *
     * Selects files with any of the specified tags
     *
     * @param	array|string	The tags to search by
     * @return	array
     */
    public function getTaggedFiles($tags)
    {
        $return_files = array();
        $hashes = array();

        // while not as nice as straight queries this allows devs to select
        // files using their own complex where clauses and we then filter from there.
        $files = File::get();

        if (is_string($tags)) {
            $tags = array_map('trim', explode('|', $tags));
        }

        Applied::select('keywords_applied.hash')
            ->join('keywords_applied', 'keywords.id', '=', 'keywords_applied.keyword_id');

        foreach ($tags as $tag) {
            Applied::orWhere('name', $tag);
        }

        $keywords = Applied::get();

        $hashes = array_map(function($keyword) {
                    return $keyword->hash;
                }, $keywords);

        // select the files
        foreach ($files as $file) {
            if (in_array($file->keywords, $hashes)) {
                $return_files[] = $file;
            }
        }

        return $return_files;
    }

    /**
     * Files listing
     *
     * Creates a list of files
     *
     * Used by the Files plugin
     *
     * @return array
     */
    public function getListing($folder_id, $tags, $limit, $offset, $type, $fetch, $order_by, $order_ord)
    {
        if ( ! empty($folder_id) && (empty($type) || in_array($type, array('a','v','d','i','o')))) {
            if (is_numeric($folder_id)) {
                $folder = Folder::find($folder_id);
            } elseif (is_string($folder_id)) {
                $folder = Folder::findByPath($folder_id);
            }
        }

        $subfolders = array();

        if (isset($folder) && $folder && in_array($fetch, array('root', 'subfolder'))) {
            // we're getting the files for an entire tree
            $fetch_id = ($fetch === 'root' ? $folder->root_id : $folder->id);

            $subfolders = Files::folderTreeRecursive($fetch_id);
        } elseif ( ! isset($folder)) { // no restrictions by folder so we'll just be getting files by their tags. Set up the join
            return array();
        }

        if (!empty($subfolders)) {
            $ids = array_merge(array((int) $folder->id), array_keys($subfolders));
            File::whereIn('folder_id', $ids);
        } else { // just the files for one folder
            File::where('folder_id', $folder->id);
        }

        $type	&&	File::where('type', $type);
        $limit	&&	File::take($limit);
        $offset	&&	File::skip($offset);

        if(!$order_ord) $order_ord = 'asc';

        $order_by && File::orderBy($order_by, $order_ord);

        if ($tags) {
            $files = Files::getTaggedFiles($tags);
        } else {
            $files = File::get();
        }

        return $files;
    }
}
