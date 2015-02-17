<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Inherit from another theme
    |--------------------------------------------------------------------------
    |
    | Set up inherit from another if the file is not exists,
    | this is work with "layouts", "partials", "views" and "widgets"
    |
    | [Notice] assets cannot inherit.
    |
    */

    'inherit' => null, //default

    /*
    |--------------------------------------------------------------------------
    | Listener from events
    |--------------------------------------------------------------------------
    |
    | You can hook a theme when event fired on activities
    | this is cool feature to set up a title, meta, default styles and scripts.
    |
    | [Notice] these event can be override by package config.
    |
    */

    'events' => array(

        // Before event inherit from package config and the theme that call before,
        // you can use this event to set meta, breadcrumb template or anything
        // you want inheriting.
        'before' => function($theme)
        {
            // You can remove this line anytime.
            // $theme->setTitle('Copyright ©  2013 - Laravel.in.th');

            $pkg = 'packages/sharenjoy/cmsharenjoy/';

            // CSS
            $theme->asset()->add('jquery-ui-css', $pkg.'js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css');
            $theme->asset()->add('entypo'       , $pkg.'css/font-icons/entypo/css/entypo.css');
            $theme->asset()->add('font-awesome' , $pkg.'css/font-icons/font-awesome/css/font-awesome.min.css');
            $theme->asset()->add('bootstrap-css', $pkg.'css/bootstrap.css');
            $theme->asset()->add('neon-core'    , $pkg.'css/neon-core.css');
            $theme->asset()->add('neon-theme'   , $pkg.'css/neon-theme.css');
            $theme->asset()->add('neon-forms'   , $pkg.'css/neon-forms.css');
            $theme->asset()->add('white'        , $pkg.'css/skins/white.css');
            $theme->asset()->add('custom-css'   , $pkg.'css/sharenjoy/custom.css');

            // Javascript
            $theme->asset()->add('jquery'      , $pkg.'js/jquery-1.11.0.min.js');
            $theme->asset()->add('gsap'        , $pkg.'js/gsap/main-gsap.js');
            $theme->asset()->add('jquery-ui-js', $pkg.'js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js');
            $theme->asset()->add('bootstrap'   , $pkg.'js/bootstrap.js');
            $theme->asset()->add('joinable'    , $pkg.'js/joinable.js');
            $theme->asset()->add('resizeable'  , $pkg.'js/resizeable.js');
            $theme->asset()->add('neon-api'    , $pkg.'js/neon-api.js');
            $theme->asset()->add('toastr'      , $pkg.'js/toastr.js');
            $theme->asset()->add('neon-custom' , $pkg.'js/neon-custom.js');
            $theme->asset()->add('reactjs'     , $pkg.'js/react/react.min.js');
            $theme->asset()->add('reactjs-jsx' , $pkg.'js/react/JSXTransformer.js');
            $theme->asset()->add('custom-js'   , $pkg.'js/sharenjoy/custom.js');

            // Breadcrumb template.
            // $theme->breadcrumb()->setTemplate('
            //     <ul class="breadcrumb">
            //     @foreach ($crumbs as $i => $crumb)
            //         @if ($i != (count($crumbs) - 1))
            //         <li><a href="{{ $crumb["url"] }}">{{ $crumb["label"] }}</a><span class="divider">/</span></li>
            //         @else
            //         <li class="active">{{ $crumb["label"] }}</li>
            //         @endif
            //     @endforeach
            //     </ul>
            // ');
        },

        // Listen on event before render a theme,
        // this event should call to assign some assets,
        // breadcrumb template.
        'beforeRenderTheme' => function($theme)
        {
            // You may use this event to set up your assets.
            // $theme->asset()->usePath()->add('core', 'core.js');
            // $theme->asset()->add('jquery', 'vendor/jquery/jquery.min.js');
            // $theme->asset()->add('jquery-ui', 'vendor/jqueryui/jquery-ui.min.js', array('jquery'));

            // Partial composer.
            // $theme->partialComposer('header', function($view)
            // {
            //     $view->with('auth', Auth::user());
            // });
        },

        // Listen on event before render a layout,
        // this should call to assign style, script for a layout.
        'beforeRenderLayout' => array(

            'default' => function($theme)
            {
                // $theme->asset()->usePath()->add('ipad', 'css/layouts/ipad.css');
            }

        )

    )

);