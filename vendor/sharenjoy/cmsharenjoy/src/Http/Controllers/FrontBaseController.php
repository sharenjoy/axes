<?php namespace Sharenjoy\Cmsharenjoy\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Auth, Route, Request, Theme, Message, Setting;

abstract class FrontBaseController extends Controller {

    use DispatchesCommands, ValidatesRequests, AppNamespaceDetectorTrait;

    /**
     * The brand name
     * @var string
     */
    protected $brandName;

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
     * The theme instancd
     * @var object
     */
    protected $theme;

    /**
     * The login member
     * @var object
     */
    protected $member;

    /**
     * Initializer.
     * @access   public
     * @return   void
     */
    public function __construct()
    {
        $this->setCommonVariable();
        $this->getAuthInfo();
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

        // Brand name from setting
        $this->brandName = Setting::get('brand_name');
        
        // Share some variables to views
        view()->share('brandName'     , $this->brandName);
        view()->share('langLocales'   , config('cmsharenjoy.locales'));
        view()->share('activeLanguage', session('sharenjoy.backEndLanguage'));

        // Set the theme
        // $this->theme = Theme::uses('front');

        // Message
        view()->share('messages', Message::getMessageBag());
    }

    protected function getAuthInfo()
    {
        // Get the login member
        if (Auth::check())
        {
            $this->member = Auth::user();

            session()->put('member', $this->member->toArray());
            view()->share('member', $this->member);
        }
    }

    protected function getModuleNamespace()
    {
        return $this->getAppNamespace().config('cmsharenjoy.moduleNamespace');
    }

    /**
     * This is the order that show layout
     * 1. view/member/create.blade.php
     * 2. view/member-index.blade.php
     * 3. view/member.blade.php (action = index)
     * 4. view/create.blade.php
     * @return View
     */
    protected function layout()
    {
        if (view()->exists($this->onController.'.'.$this->onAction))
        {
            return view($this->onController.'.'.$this->onAction);
        }
        elseif (view()->exists($this->onController.'-'.$this->onAction))
        {
            return view($this->onController.'-'.$this->onAction);
        }
        elseif ($this->onAction == 'index' && view()->exists($this->onController))
        {
            return view($this->onController);
        }
        elseif (view()->exists($this->onAction))
        {
            return view($this->onAction);
        }
    }

}