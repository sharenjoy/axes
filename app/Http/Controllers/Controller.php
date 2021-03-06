<?php

namespace App\Http\Controllers;

use Theme, Route, Request;
use Auth, Message, Setting;
use Illuminate\Support\Str;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

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
     * The language value
     * @var string
     */
    protected $language;

    /**
     * Initializer.
     * @access   public
     * @return   void
     */
    public function __construct()
    {
        $this->setCommonVariable();
        $this->getAuthInfo();
        $this->setLanguage();
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

    protected function setLanguage()
    {
        if (config('cmsharenjoy.language_default')) {
            $this->language = config('cmsharenjoy.language_default');

            if (array_key_exists(strtolower(Request::segment(1)), config('cmsharenjoy.language'))) {
                $this->language = strtolower(Request::segment(1));
            }

            session()->put('content-language', $this->language);
        }
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
     * This is the order that show layout
     * 1. view/member/create.blade.php
     * 2. view/member-index.blade.php
     * 3. view/member.blade.php (action = index)
     * 4. view/create.blade.php
     * @return View
     */
    protected function layout()
    {
        $langFolder = $this->language ? $this->language.'.' : '';

        if (view()->exists($langFolder.$this->onController.'.'.$this->onAction))
        {
            return view($langFolder.$this->onController.'.'.$this->onAction);
        }
        elseif (view()->exists($langFolder.$this->onController.'-'.$this->onAction))
        {
            return view($langFolder.$this->onController.'-'.$this->onAction);
        }
        elseif ($this->onAction == 'index' && view()->exists($langFolder.$this->onController))
        {
            return view($langFolder.$this->onController);
        }
        elseif (view()->exists($langFolder.$this->onAction))
        {
            return view($langFolder.$this->onAction);
        }

        throw new \Sharenjoy\Cmsharenjoy\Exception\ViewNotFoundException("Can not found view -> {$this->language} {$this->onController} {$this->onAction}");
    }
}
