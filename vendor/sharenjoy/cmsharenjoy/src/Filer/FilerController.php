<?php namespace Sharenjoy\Cmsharenjoy\Filer;

use Illuminate\Http\Request;
use Sharenjoy\Cmsharenjoy\Http\Controllers\BaseController;
use Config, Lang, Theme, Message, Session;
use Response, App, Redirect, Filer;

/**
 * PyroCMS file Admin Controller
 *
 * Provides an admin for the file module.
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Files\Controllers
 */
class FilerController extends BaseController {

    protected $filer;

    private $_folders   = array();
    private $_type      = null;
    private $_ext       = null;
    private $_filename  = null;

    // ------------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        $allowed_extensions = array();
        $config = Config::get('filer.allowed_file_ext');

        foreach ($config as $type) {
            $allowed_extensions = array_merge($allowed_extensions, $type);
        }
    }

    /**
     * Folder Listing
     */
    public function getIndex($parentId = null)
    {
        \Debugbar::disable();

        if (is_null($parentId))
        {
            $model = Folder::orderBy('sort')->first();
            $parentId = $model->id;
        }

        $folderTree = Filer::folderTree();

        // make a parser instance
        $parser = App::make('Sharenjoy\Cmsharenjoy\Utilities\Parser');
        $folderTreeBuilder = $parser->treeBuilder(
            $folderTree, 
            '<li class="dd-item" data-id="{id}"><a href="'.$this->objectUrl.'/index/{id}"><div class="dd-handle"><i class="fa fa-folder-o"></i>&nbsp;&nbsp;&nbsp;<span>{name}</span></div></a> {children} </li>',
            'ul class="dd-list"'
        );

        $fileResult = $this->foldercontents($parentId);
        if ( ! $fileResult['status'])
        {
            Message::error($fileResult['message']);
        }

        $maxSize = Filer::getMaxSizeAllowed() > Filer::getMaxSizePossible() ? 
                                                Filer::getMaxSizePossible() : 
                                                Filer::getMaxSizeAllowed();
        // Convert bytes to mega                                                
        $maxSize = $maxSize / 1048576;

        return $this->layout()->with('parentId', $parentId)
                              ->with('fileResult', $fileResult)
                              ->with('folderTree', $folderTreeBuilder)
                              ->with('uploadMaxFilesize', $maxSize);
    }

    public function getFilemanager($parentId = null)
    {
        \Debugbar::disable();

        if (is_null($parentId))
        {
            $model = Folder::orderBy('sort')->first();
            $parentId = $model->id;
        }

        $folderTree = Filer::folderTree();

        // make a parser instance
        $parser = App::make('Sharenjoy\Cmsharenjoy\Utilities\Parser');
        $folderTreeBuilder = $parser->treeBuilder(
            $folderTree, 
            '<li class="dd-item" data-id="{id}"><a href="'.$this->objectUrl.'/filemanager/{id}"><div class="dd-handle"><i class="fa fa-folder-o"></i>&nbsp;&nbsp;&nbsp;{name}</div></a> {children} </li>',
            'ul class="dd-list"'
        );

        $fileResult = $this->foldercontents($parentId);
        if ( ! $fileResult['status'])
        {
            Message::error($fileResult['message']);
        }

        $maxSize = Filer::getMaxSizeAllowed() > Filer::getMaxSizePossible() ? 
                                                Filer::getMaxSizePossible() : 
                                                Filer::getMaxSizeAllowed();
        // Convert bytes to mega                                                
        $maxSize = $maxSize / 1048576;

        return $this->layout()->with('parentId', $parentId)
                              ->with('fileResult', $fileResult)
                              ->with('folderTree', $folderTreeBuilder)
                              ->with('uploadMaxFilesize', $maxSize);
    }

    public function getCkeditor($parentId = null)
    {
        \Debugbar::disable();

        if (is_null($parentId))
        {
            $model = Folder::orderBy('sort')->first();
            $parentId = $model->id;
        }

        $folderTree = Filer::folderTree();

        // make a parser instance
        $parser = App::make('Sharenjoy\Cmsharenjoy\Utilities\Parser');
        $folderTreeBuilder = $parser->treeBuilder(
            $folderTree, 
            '<li class="dd-item" data-id="{id}"><a href="'.$this->objectUrl.'/ckeditor/{id}"><div class="dd-handle"><i class="fa fa-folder-o"></i>&nbsp;&nbsp;&nbsp;{name}</div></a> {children} </li>',
            'ul class="dd-list"'
        );

        $fileResult = $this->foldercontents($parentId);
        if ( ! $fileResult['status'])
        {
            Message::error($fileResult['message']);
        }

        $maxSize = Filer::getMaxSizeAllowed() > Filer::getMaxSizePossible() ? 
                                                Filer::getMaxSizePossible() : 
                                                Filer::getMaxSizeAllowed();
        // Convert bytes to mega                                                
        $maxSize = $maxSize / 1048576;

        return $this->layout()->with('parentId', $parentId)
                              ->with('fileResult', $fileResult)
                              ->with('folderTree', $folderTreeBuilder)
                              ->with('uploadMaxFilesize', $maxSize);
    }

    public function getFilealbum($parentId = null)
    {
        \Debugbar::disable();
        
        $fileResult = $this->foldercontents($parentId);
        if ( ! $fileResult['status'])
        {
            Message::error($fileResult['message']);
        }

        $maxSize = Filer::getMaxSizeAllowed() > Filer::getMaxSizePossible() ? 
                                                Filer::getMaxSizePossible() : 
                                                Filer::getMaxSizeAllowed();
        // Convert bytes to mega                                                
        $maxSize = $maxSize / 1048576;

        return $this->layout()->with('parentId', $parentId)
                              ->with('fileResult', $fileResult)
                              ->with('uploadMaxFilesize', $maxSize);
    }

    /**
     * Create a new folder
     *
     * Grabs the parent id and the name of the folder from POST data.
     */
    public function postNewfolder($toWhere = 'index', Request $request)
    {
        $parent_id = $request->input('parent', 0);
        $input     = $request->all();

        $validator = new FilerValidator();
        $result = $validator->setRule('newFolderRules')->valid($input, 'flash');
        
        if ($result !== true)
        {
            return Redirect::to($this->objectUrl)->withInput();
        }

        $input['name'] = $input['folder_name'];
        $result = Filer::createFolder($parent_id, $input['name']);

        Message::success(trans('files.folder_created'));

        return Redirect::to($this->objectUrl.'/'.$toWhere.'/'.$result['data']['id']);
    }

    /**
     * Set the initial folder ID to load contents for
     *
     * @deprecated
     *
     * Accepts the parent id and sets it as flash data
     */
    public function initial_folder_contents($id)
    {
        $this->session->set_flashdata('initial_folder_contents', $id);

        redirect(site_url('admin/files'));
    }

    /**
     * Get all files and folders within a folder
     *
     * Grabs the parent id from the POST data.
     */
    public function foldercontents($parent)
    {
        return Filer::folderContents($parent);
    }

    /**
     * See if a container exists with that name.
     *
     * This is different than folder_exists() as this checks for unindexed containers.
     * Grabs the name of the container and the location from the POST data.
     */
    public function check_container()
    {
        $name = $this->input->post('name');
        $location = $this->input->post('location');

        echo json_encode(Filer::checkContainer($name, $location));
    }

    /**
     * Set the order of files and folders
     */
    public function postOrder(Request $request)
    {
        if( ! Request::ajax()) Response::json('error', 400);

        $id_value   = $request->input('id_value');
        $sort_value = $request->input('sort_value');
        
        foreach($id_value as $key => $id)
        {
            if($id)
            {
                $sort = $sort_value[$key];
                $file = File::find($id);
                $file->update(array('sort' => $sort));
            }
        }

        // let the files library format the return array like all the others
        return Message::json(200, pick_trans('success_ordered'));
    }

    /**
     * Rename a folder
     */
    public function rename_folder()
    {
        // this is just a safeguard if they circumvent the JS permissions
        if ( ! in_array('edit_folder', Filer::allowedActions($this->current_user))) {
            show_error(trans('files.no_permissions'));
        }

        if ($id = $this->input->post('folder_id') and $name = $this->input->post('name')) {
            $result = Filer::renameFolder($id, $name);

            $result['status'] AND Events::trigger('file_folder_updated', $id);

            echo json_encode($result);
        }
    }

    /**
     * Delete an empty folder
     */
    public function delete_folder()
    {
        // this is just a safeguard if they circumvent the JS permissions
        if ( ! in_array('delete_folder', Filer::allowedActions($this->current_user))) {
            show_error(trans('files.no_permissions'));
        }

        if ($id = $this->input->post('folder_id')) {
            $result = Filer::deleteFolder($id);

            $result['status'] AND Events::trigger('file_folder_deleted', $id);

            echo json_encode($result);
        }
    }

    /**
     * Upload files
     */
    public function postUpload(Request $request)
    {
        $parentId = $request->input('parent_id');
        $file     = $request->file('file');

        // upload file
        $result = Filer::upload($parentId, false, $file);

        if ($result['status'] == true)
        {
            $result['data']['append'] = <<<EOE
            <li original-title="" class="file type-{$result['data']['type']}" data-id="{$result['data']['id']}" data-name="{$result['data']['filename']}" data-extension="{$result['data']['extension']}" data-type="{$result['data']['type']}">{img}<span class="name-text">{$result['data']['name']}.{$result['data']['extension']}</span></li>
EOE;
            $result['data']['append_form'] = '<input type="hidden" value="'.$result['data']['id'].'" />';
            
            if ($result['data']['type'] == 'i')
            {
                $img = '<img src="'.asset('uploads/thumbs/'.$result['data']['filename'].'.'.$result['data']['extension']).'" alt="'.$result['data']['alt_attribute'].'">';
                $result['data']['append'] = str_replace('{img}', $img, $result['data']['append']);
            }
            else
            {
                $result['data']['append'] = str_replace('{img}', '', $result['data']['append']);
            }
            
        }

        return Response::json($result, 200);
    }

    public function postUpdatefile($toWhere = 'index', Request $request)
    {
        $input = $request->all();

        $validator = new FilerValidator();
        $result = $validator->setRule('fileUpdateRules')->valid($input, 'flash');
        
        if ($result !== true)
        {
            return Redirect::to($this->objectUrl.'/index/'.$input['folder_id'])->withInput();
        }

        $file = File::find($input['id']);
        $file->name          = $input['name'];
        $file->description   = $input['description'];
        $file->alt_attribute = $input['alt_attribute'];
        $file->save();

        Message::success(trans('files.item_updated'));
        return Redirect::to($this->objectUrl.'/'.$toWhere.'/'.$file->folder_id);
    }

    /**
     * Rename a file
     */
    public function rename_file()
    {
        // this is just a safeguard if they circumvent the JS permissions
        if ( ! in_array('edit_file', Filer::allowedActions($this->current_user))) {
            show_error(trans('files.no_permissions'));
        }

        if ($id = $this->input->post('file_id') and $name = $this->input->post('name')) {
            $result = Filer::renameFile($id, $name);

            $result['status'] AND Events::trigger('file_updated', $result['data']);

            echo json_encode($result);
        }
    }

    /**
     * Edit description of a file
     */
    public function save_description()
    {
        $this->load->library('keywords/keywords');

        $description    = $this->input->post('description');
        $keywords_hash  = $this->keywords->process($this->input->post('keywords'), $this->input->post('old_hash'));
        $alt_attribute  = $this->input->post('alt_attribute');

        if ($id = $this->input->post('file_id')) {
            $this->file_m->update($id, array('description' => $description, 'keywords' => $keywords_hash, 'alt_attribute' => $alt_attribute));

            echo json_encode(Filer::result(true, trans('files.description_saved')));
        }
    }

    /**
     * Edit the "alt" attribute of an image file
     */
    public function save_alt()
    {
        if ($id = $this->input->post('file_id') AND $alt_attribute = $this->input->post('alt_attribute')) {
            $this->file_m->update($id, array('alt_attribute' => $alt_attribute));

            echo json_encode(Filer::result(TRUE, trans('files.alt_saved')));
        }
    }

    /**
     * Edit location of a folder (S3/Cloud Files/Local)
     */
    public function save_location()
    {
        // this is just a safeguard if they circumvent the JS permissions
        if ( ! in_array('set_location', Filer::allowedActions($this->current_user))) {
            show_error(trans('files.no_permissions'));
        }

        if ($id = $this->input->post('folder_id') and $location = $this->input->post('location') and $container = $this->input->post('container')) {
            $this->file_folders_m->update($id, array('location' => $location));

            echo json_encode(Filer::createContainer($container, $location, $id));
        }
    }

    /**
     * Pull new files down from the cloud location
     */
    public function synchronize()
    {
        // this is just a safeguard if they circumvent the JS permissions
        if ( ! in_array('synchronize', Filer::allowedActions($this->current_user))) {
            show_error(trans('files.no_permissions'));
        }

        if ($id = $this->input->post('folder_id')) {
            echo json_encode(Filer::synchronize($id));
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Delete a file
     *
     * @access  public
     * @return  void
     */
    public function postDeletefile(Request $request)
    {
        $id = $request->input('file_id');
        $name = $request->input('file_name');

        if ($id) {
            $result = Filer::deleteFile($id);

            return Response::json($result, 200);
        }
    }

    /**
     * find for file
     */
    public function postFind(Request $request)
    {
        if( ! Request::ajax())
        {
            Response::json('error', 400);
        }

        $id = $request->input('file_id');
        
        $result = Filer::getFile($id);

        return Response::json($result, 200);
    }

    /**
     * Delete a file
     *
     * @access  public
     * @return  void
     */
    public function postDeletefolder(Request $request)
    {

        $id = $request->input('delete_folder_id');

        $result = Filer::deleteFolder($id);
        
        if ( ! $result['status'])
        {
            Message::error($result['message']);

            return Redirect::to($this->objectUrl.'/index/'.$id);
        }

        Message::success($result['message']);

        return Redirect::to($this->objectUrl);
    }

    /**
     * Search for files and folders
     */
    public function search()
    {
        echo json_encode(Filer::search($this->input->post('search')));
    }

}
