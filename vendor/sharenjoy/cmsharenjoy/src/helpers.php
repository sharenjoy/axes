<?php

if ( ! function_exists('adminUrl'))
{
	function adminUrl($str)
	{
		$prefix = _ADMIN_BASE_;
		return $prefix . $str;
	}

}

if ( ! function_exists('currentUserName'))
{
	function currentUserName()
	{
		$user = Auth::getUser();
		if ( ! is_null($user))
		{
			return $user->username;
		}

		return null;
	}
}

if ( ! function_exists('currentUserId'))
{
	function currentUserId()
	{
		$user = Auth::getUser();
		if ( ! is_null($user))
		{
			return $user->id;
		}

		return null;
	}
}


if ( ! function_exists('is_moderator'))
{
	function is_moderator()
	{
		$Acl = app('AccessControl');
		return $Acl->is_moderator();
	}
}


if ( ! function_exists('apiUrl'))
{
	function apiUrl($str)
	{
		$prefix = _API_BASE_;
		return $prefix . $str;
	}
}

if ( ! function_exists('frontUrl'))
{
	function frontUrl($str)
	{
		$prefix = _FRONT_BASE_;
		return $prefix . $str;
	}
}

if ( ! function_exists('dd'))
{
	function dd($value)
	{
		die(call_user_func_array('var_dump', func_get_args()));
	}
}


if ( ! function_exists('admin_asset'))
{
	function admin_asset($path)
	{
		return URL::asset('packages/raftalks/ravel/'.$path);
	}
}

if ( ! function_exists('aw'))
{
	function aw($str)
	{
		return "{{ $str }}";
	}
}

if ( ! function_exists('showflag'))
{
	function showflag($ccode)
	{
		return "<img  class='flag flag-$ccode'/>";
	}
}

if ( ! function_exists('langflag'))
{
	function langflag($lang)
	{
		$ccode = Config::get("ravel::flags.$lang",'en');
		if ( ! is_null($ccode))
		{
			return showflag($ccode);
		}
	}
}

if ( ! function_exists('current_locale'))
{
    function current_locale()
    {
        return Config::get('app.locale');
    }
}

if ( ! function_exists('current_backend_language'))
{
    function current_backend_language()
    {
        if (session()->has('cmsharenjoy.language') && !is_null(config('cmsharenjoy.language_default'))) {
            return session('cmsharenjoy.language');
        }

        return null;
    }
}

if ( ! function_exists('showActivated'))
{
	function showActivated()
	{
		return '<p>Activated</p>';
	}
}


if ( ! function_exists('showDeactivated'))
{
	function showDeactivated()
	{
		return '<p>Deactivated</p>';
	}
}


if ( ! function_exists('makeApiKey'))
{
	function makeApiKey()
	{
		$uniqid = uniqid();
		$rand = rand(1000,9999);
		$key = md5($rand . $uniqid);
		
		return $key;
	}
}

if ( ! function_exists('is_closure'))
{
	function is_closure($t) {
   		 return is_object($t) && ($t instanceof Closure);
	}
}


if ( ! function_exists('buildTree'))
{
	function buildTree(array $elements, $parentId = 0, $parentKey = 'parent_id', $childKey='children') {
	    
	    $branch = array();
	    foreach ($elements as $menu_id => $element) {
	        if ($element[$parentKey] == $parentId) {
	            $children = buildTree($elements, $menu_id, $parentKey, $childKey);
	            if ($children) {
	                $element[$childKey] = $children;
	            }
	            $branch[] = $element;
	        }
	    }

	    return $branch;
	}
}

if ( ! function_exists('array_column'))
{
	function array_column(array $input, $columnKey, $indexKey = null) {
        $result = array();
   
        if (null === $indexKey) {
            if (null === $columnKey) {
                // trigger_error('What are you doing? Use array_values() instead!', E_USER_NOTICE);
                $result = array_values($input);
            }
            else {
                foreach ($input as $row) {
                    $result[] = $row[$columnKey];
                }
            }
        }
        else {
            if (null === $columnKey) {
                foreach ($input as $row) {
                    $result[$row[$indexKey]] = $row;
                }
            }
            else {
                foreach ($input as $row) {
                    $result[$row[$indexKey]] = $row[$columnKey];
                }
            }
        }
   
        return $result;
    }
}

if ( ! function_exists('is_really_writable'))
{
    /**
     * Tests for file writability
     *
     * is_writable() returns TRUE on Windows servers when you really can't write to
     * the file, based on the read-only attribute. is_writable() is also unreliable
     * on Unix servers if safe_mode is on.
     *
     * @param   string
     * @return  void
     */
    function is_really_writable($file)
    {
        // If we're on a Unix server with safe_mode off we call is_writable
        if (DIRECTORY_SEPARATOR === '/' && (bool) @ini_get('safe_mode') === FALSE)
        {
            return is_writable($file);
        }

        /* For Windows servers and safe_mode "on" installations we'll actually
         * write a file then read it. Bah...
         */
        if (is_dir($file))
        {
            $file = rtrim($file, '/').'/'.md5(mt_rand());
            if (($fp = @fopen($file, FOPEN_WRITE_CREATE)) === FALSE)
            {
                return FALSE;
            }

            fclose($fp);
            @chmod($file, DIR_WRITE_MODE);
            @unlink($file);
            return TRUE;
        }
        elseif ( ! is_file($file) OR ($fp = @fopen($file, FOPEN_WRITE_CREATE)) === FALSE)
        {
            return FALSE;
        }

        fclose($fp);
        return TRUE;
    }
}

if ( ! function_exists('format_date'))
{
    /**
     * Formats a timestamp into a human date format.
     *
     * @param int $unix The UNIX timestamp
     * @param string $format The date format to use.
     * @return string The formatted date.
     */
    function format_date($unix, $format = '')
    {
        if ($unix == '' || !is_numeric($unix)) {
            $unix = strtotime($unix);
        }

        if ( ! $format) {
            $format = Setting::get('date_format');
        }

        return strstr($format, '%') !== false ? ucfirst(utf8_encode(strftime($format, $unix))) : date($format, $unix);
    }
}

if ( ! function_exists('pick_trans'))
{
    /**
     * To choose the language from right place
     */
    function pick_trans($item, $options = array())
    {
        // If the item includes :: symbol
        if (strpos($item, '::') !== false)
        {
            return app('translator')->trans($item, $options);
        }

        $pkg = Session::get('onPackage');

        $local_reference = "{$pkg}.{$item}";

        if (app('translator')->has($local_reference))
        {
            return app('translator')->trans($local_reference, $options);
        }
        
        $pkg_reference = "{$pkg}::{$pkg}.{$item}";

        if (app('translator')->has($pkg_reference))
        {
            return app('translator')->trans($pkg_reference, $options);
        }

        if (app('translator')->has($item))
        {
            return app('translator')->trans($item, $options);
        }

        if (app('translator')->has('cmsharenjoy.'.$item))
        {
            return app('translator')->trans('cmsharenjoy.'.$item, $options);
        }
        
        return false;
    }
}

if ( ! function_exists('ii'))
{
    /**
     * For Debugbar info method
     * @param mixed $data
     * @return Debugbar
     */
    function ii($data, $warning = null)
    {
        return is_null($warning) ? Debugbar::info($data) : Debugbar::warning($warning).Debugbar::info($data);
    }
}

if ( ! function_exists('ww'))
{
    /**
     * For Debugbar warning method
     * @param mixed $data
     * @return Debugbar
     */
    function ww($warning = null)
    {
        return is_null($warning) ? Debugbar::warning('warning') : Debugbar::warning($warning);
    }
}

if ( ! function_exists('start'))
{
    /**
     * For Debugbar start measure method
     */
    function start($name = 'Custom vendor', $description = null)
    {
        return Debugbar::startMeasure($name, $description);
    }
}

if ( ! function_exists('stop'))
{
    /**
     * For Debugbar stop measure method
     */
    function stop($name = 'Custom vendor')
    {
        return Debugbar::stopMeasure($name);
    }
}

if ( ! function_exists('set_package_asset_to_view'))
{
    /**
     * To set the asset to View
     */
    function set_package_asset_to_view($asset)
    {
        $path    = Config::get('assets.path');
        $package = Config::get('assets.package.'.$asset);

        if (count($package))
        {
            foreach ($package as $key => $value)
            {
                if ($value['queue'])
                {
                    Theme::asset()->queue($value['type'])
                                  ->add($key, $path.$value['file']);
                }
                else
                {
                    Theme::asset()->add($key, $path.$value['file']);
                }
            }
        }
    }
}

if ( ! function_exists('N2L'))
{
    /**
     * To convert the number to string
     */
    function N2L($number)
    {
        $result = array();
        $tens = floor($number / 10);
        $units = $number % 10;

        $words = array
        (
            'units' => array('', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eightteen', 'Nineteen'),
            'tens' => array('', '', 'Twenty', 'Thirty', 'Fourty', 'Fifty', 'Sixty', 'Seventy', 'Eigthy', 'Ninety')
        );

        if ($tens < 2)
        {
            $result[] = $words['units'][$tens * 10 + $units];
        }
        else
        {
            $result[] = $words['tens'][$tens];

            if ($units > 0)
            {
                $result[count($result) - 1] .= '-' . $words['units'][$units];
            }
        }

        if (empty($result[0])) $result[0] = 'Zero';

        return trim(implode(' ', $result));
    }
}

if ( ! function_exists('trans_options'))
{
    /**
     * To translate the option
     */
    function trans_options($name)
    {
        $options = config($name);

        if ( ! $options) {return false;}

        $fun = function($value) {
            if ( ! pick_trans($value)) {return $value;}
            return pick_trans($value);
        };

        return array_map($fun, $options);
    }
}

if ( ! function_exists('message'))
{
    /**
     * To output the message object
     */
    function message()
    {
        return app('Illuminate\Support\Contracts\MessageProviderInterface');
    }
}

if ( ! function_exists('success'))
{
    /**
     * To output the message with success
     */
    function success($message)
    {
        return message()->success($message);
    }
}

if ( ! function_exists('error'))
{
    /**
     * To output the message with error
     */
    function error($message)
    {
        return message()->error($message);
    }
}

if ( ! function_exists('unique_array'))
{
    /**
     * To filter the array for the unique by the key
     * Input
     * [0]=>array("id"=>"1","name"=>"Mike","num"=>"9876543210"),
     * [1]=>array("id"=>"2","name"=>"Carissa","num"=>"08548596258"),
     * [2]=>array("id"=>"1","name"=>"Mathew","num"=>"784581254"),
     * Output
     * [0]=>array("id"=>"1","name"=>"Mike","num"=>"9876543210"),
     * [1]=>array("id"=>"2","name"=>"Carissa","num"=>"08548596258"),
     */
    function unique_array($array, $key)
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();
        
        foreach($array as $val)
        {
            if( ! in_array($val[$key],$key_array))
            {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }
}

if ( ! function_exists('diff_for_humans'))
{
    /**
     * To output the Humans times
     */
    function diff_for_humans($time)
    {
        $string = $time->diffForHumans();

        $string = str_replace(['seconds', 'second'], '秒鐘', $string);
        $string = str_replace(['minutes', 'minute'], '分鐘', $string);
        $string = str_replace(['hours', 'hour'], '小時', $string);
        $string = str_replace(['days', 'day'], '天', $string);
        $string = str_replace(['weeks', 'week'], '星期', $string);
        $string = str_replace(['months', 'month'], '個月', $string);
        $string = str_replace(['years', 'year'], '年', $string);
        $string = str_replace('ago', '前', $string);
        $string = str_replace(' ', '', $string);

        return $string;
    }
}

if ( ! function_exists('category_options'))
{
    /**
     * To output the Humans times
     */
    function category_options($category)
    {
        return \Categorize::getCategoryProvider()
                            ->whereType($category)
                            ->orderBy('sort')
                            ->lists('title', 'id');
    }
}

if ( ! function_exists('img_resize'))
{
    /**
     * To resize the image
     */
    function img_resize($filename, $width, $height)
    {
        $path      = config('filer.path');
        $thumbPath = config('filer.thumbPath');

        $imageInfo      = pathinfo($filename);
        $targetFilename = "{$imageInfo['filename']}_{$width}x{$height}.{$imageInfo['extension']}";

        $imagePath      = public_path().$path.'/'.$filename;
        $thumbImagePath = public_path().$thumbPath.'/'.$targetFilename;
        
        if (! file_exists($thumbImagePath)) {
            \Image::make($imagePath)->fit($width, $height)->save($thumbImagePath);
        }
        
        return asset($thumbPath.'/'.$targetFilename);
    }
}
