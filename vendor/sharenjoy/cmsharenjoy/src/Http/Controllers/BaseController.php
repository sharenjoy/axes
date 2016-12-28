<?php

namespace Sharenjoy\Cmsharenjoy\Http\Controllers;

use Route, Request, Theme;
use Message, Setting, Auth;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Sharenjoy\Cmsharenjoy\User\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Sharenjoy\Cmsharenjoy\Exception\ViewNotFoundException;

abstract class BaseController extends Controller
{
    use DispatchesJobs, AppNamespaceDetectorTrait, ValidatesRequests, AuthorizesRequests, AuthorizesResources;
    
    /**
     * The URL segment that can be used to access the system
     * @var string
     */
    protected $accessUrl;

    /**
     * To manage some function that can open or not
     * @var array
     */
    protected $functionRules;

    /**
     * The URL to get the root of this object ( /admin/posts for example )
     * @var string
     */
    protected $objectUrl;

    /**
     * The URL to preview a new entry
     * @var string
     */
    protected $previewUrl;

    /**
     * The URL to create a new entry
     * @var string
     */
    protected $createUrl;

    /**
     * The URL that is used to edit shit
     * @var string
     */
    protected $updateUrl;

    /**
     * The URL to delete an entry
     * @var string
     */
    protected $deleteUrl;

    /**
     * The URL to sort page
     * @var string
     */
    protected $sortUrl;

    /**
     * The controller active right away
     * @var string
     */
    protected $onController;

    /**
     * The action active right away
     * @var string
     */
    protected $onMethod;

    /**
     * The action active right away
     * @var string
     */
    protected $onAction;

    /**
     * The package active right away
     * @var string
     */
    protected $onPackage;

    /**
     * The theme instancd
     * @var object
     */
    protected $theme;

    /**
     * The login user
     * @var object
     */
    protected $user;

    /**
     * Initializer.
     * @access   public
     * @return   void
     */
    public function __construct()
    {
        $this->middleware('admin.auth');

        $this->setCommonVariable();
        $this->getAuthInfo();
        $this->setPackageInfo();
        $this->setHandyUrls();
        $this->setContentLanguage();
        $this->parseMenuItems();
        $this->setSettings();
    }

    protected function setCommonVariable()
    {
        // Achieve that segment
        $this->accessUrl = config('cmsharenjoy.access_url');
        
        // Get the action name
        $routeArray = Str::parseCallback(Route::currentRouteAction(), null);
        
        if (last($routeArray) != null)
        {
            // Remove 'controller' from the controller name.
            $controller = str_replace('Controller', '', class_basename(head($routeArray)));

            // Take out the method from the action.
            $action = str_replace(['get', 'post', 'patch', 'put', 'delete'], '', last($routeArray));

            // post, report
            $this->onController = strtolower($controller);
            session()->put('onController', $this->onController);
            view()->share('onController', $this->onController);

            // get-create, post-create
            $this->onMethod = Str::slug(Request::method(). '-' .$action);
            session()->put('onMethod', $this->onMethod);
            view()->share('onMethod', $this->onMethod);

            // create, update
            $this->onAction = strtolower($action);
            session()->put('onAction', $this->onAction);
            view()->share('onAction', $this->onAction);
        }

        view()->share('functionRules' , $this->functionRules);
        view()->share('langLocales'   , config('cmsharenjoy.locales'));
        view()->share('activeLanguage', session('sharenjoy.backEndLanguage'));

        // Set the theme
        $this->theme = Theme::uses('admin');

        // Message
        view()->share('messages', Message::getMessageBag());
    }

    protected function getAuthInfo()
    {
        // Get the login user
        if (Auth::guard('admin')->check())
        {
            $this->user = Auth::guard('admin')->user();

            session()->put('user', $this->user->toArray());
            view()->share('user', $this->user->toArray());
        }
    }

    protected function getPackageInfo()
    {
        return 'cmsharenjoy';
    }

    protected function setPackageInfo()
    {
        $this->onPackage = $this->getPackageInfo();
        
        // active package
        session()->put('onPackage', $this->onPackage);
        view()->share('onPackage', $this->onPackage);
    }

    /**
     * Set the URL's to be used in the views
     * @return void
     */
    protected function setHandyUrls()
    {
        $this->objectUrl  = is_null($this->objectUrl)  ? url($this->accessUrl.'/'.$this->onController) : null;
        $this->previewUrl = is_null($this->previewUrl) ? $this->objectUrl.'/preview/' : null;
        $this->createUrl  = is_null($this->createUrl)  ? $this->objectUrl.'/create' : null;
        $this->updateUrl  = is_null($this->updateUrl)  ? $this->objectUrl.'/update/' : null;
        $this->deleteUrl  = is_null($this->deleteUrl)  ? $this->objectUrl.'/delete/' : null;
        $this->sortUrl    = is_null($this->sortUrl)    ? $this->objectUrl.'/sort' : null;

        // Share these variables with any views
        view()->share('accessUrl', $this->accessUrl);
        session()->put('accessUrl', $this->accessUrl);

        view()->share('objectUrl', $this->objectUrl);
        session()->put('objectUrl', $this->objectUrl);

        view()->share('previewUrl', $this->previewUrl);
        view()->share('createUrl', $this->createUrl);
        view()->share('updateUrl', $this->updateUrl);
        view()->share('deleteUrl', $this->deleteUrl);
        view()->share('sortUrl',   $this->sortUrl);
    }

    protected function setContentLanguage()
    {
        if (! session()->has('cmsharenjoy.language') && ! is_null(config('cmsharenjoy.language_default'))) {
            session()->put('cmsharenjoy.language', config('cmsharenjoy.language_default'));
        }
    }

    /**
     * To parse the menu which one is actived
     * @return View share variable
     */
    protected function parseMenuItems()
    {
        $menuItems = config('cmsharenjoy.menu_items');
        $masterMenu = null;
        $subMenu = null;

        foreach ($menuItems as $url => $items)
        {
            if (isset($items['sub']))
            {
                foreach ($items['sub'] as $suburl => $item)
                {
                    if (strpos($suburl, '?') !== false)
                    {
                        // earse behind and include of the '?'
                        $suburl = substr_replace($suburl, '', strpos($suburl, '?'));
                    }

                    if (Request::is("$this->accessUrl/$suburl*"))
                    {
                        $masterMenu = $url;
                        $subMenu = $suburl;
                    }
                }
            }
            else
            {
                if (strpos($url, '?') !== false)
                {
                    $url = substr_replace($url, '', strpos($url, '?'));
                }

                if (Request::is("$this->accessUrl/$url*"))
                {
                    $masterMenu = $url;
                }
            }
        }

        view()->share('masterMenu', $masterMenu);
        view()->share('subMenu', $subMenu);
        view()->share('menuItems', $menuItems);
    }

    protected function setSettings()
    {
        session()->put('cmsharenjoy.settings', Setting::all());
    }

    protected function getModuleNamespace()
    {
        return $this->getAppNamespace().config('cmsharenjoy.moduleNamespace');
    }

    /**
     * Setting the output layout priority
     * @return view
     */
    protected function layout()
    {
        $action = $this->onAction;

        // If action equat sort so that set the action to index
        $action = $this->onMethod == 'get-sort' ? 'index' : $action;
        
        // Get reop directory from config
        $commonLayout = config('cmsharenjoy.commonLayoutDirectory');
        
        $pathA = $this->onController.'.'.$action;
        $pathB = $commonLayout.'.'.$action;

        // resources/views/admin/member/create
        if (view()->exists($this->accessUrl.'.'.$pathA))
        {
            return view($this->accessUrl.'.'.$pathA);
        }

        // organization/views/member/create
        if (view()->exists($this->onPackage.'::'.$pathA))
        {
            return view($this->onPackage.'::'.$pathA);
        }
        
        // organization/views/common/create
        if (view()->exists($this->onPackage.'::'.$pathB))
        {
            return view($this->onPackage.'::'.$pathB);
        }
        
        // resources/views/admin/common/create
        if (view()->exists($this->accessUrl.'.'.$pathB))
        {
            return view($this->accessUrl.'.'.$pathB);
        }

        throw new ViewNotFoundException("The view can not be found. \$action: {$action} \$onMethod: {$this->onMethod}");
    }

}