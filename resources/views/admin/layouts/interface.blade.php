<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
        <link rel="shortcut icon" href="{{asset(Config::get('cmsharenjoy.logo.favicon.path'))}}">
        
        <meta http-equiv="expires" content="-1">
        <meta name="robots" content="none">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>@yield('title')</title>
        
        <!-- Assets styles Starts -->
        {!!Theme::asset()->styles()!!}
        <!-- Assets styles Ends -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
        
        <!-- Section styles Starts -->
        @section('styles')
        @show
        <!-- Section styles Ends -->
        
        <!-- Final styles Starts -->
        {!!Theme::asset()->container('final')->styles()!!}
        <!-- Final styles Ends -->

        <!--[if lt IE 9]><script src="{{asset('packages/sharenjoy/cmsharenjoy/js/ie8-responsive-file-warning.js')}}"></script><![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <!-- page-body Starts -->
    <body class="page-body skin-white">
        
        <!-- page-container Starts -->
        <div class="page-container">
        <!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
            
            <!-- sidebar-menu Starts -->
            <div class="sidebar-menu">

                <header class="logo-env">
            
                    <!-- logo -->
                    <div class="logo">
                        <a href="{{url('/')}}" target="_blank">
                            <img src="{{asset(Config::get('cmsharenjoy.logo.index.path'))}}" width="{{Config::get('cmsharenjoy.logo.index.width')}}" alt="" />
                        </a>
                    </div>
                    
                    <!-- logo collapse icon -->
                    <div class="sidebar-collapse">
                        <a href="#" class="sidebar-collapse-icon with-animation"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
                            <i class="entypo-menu"></i>
                        </a>
                    </div>
                    
                    <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
                    <div class="sidebar-mobile-menu visible-xs">
                        <a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
                            <i class="entypo-menu"></i>
                        </a>
                    </div>
                    
                </header>

                @if($menuItems)
                <!-- main-menu Starts -->
                <ul id="main-menu" class="">
                <!-- add class "multiple-expanded" to allow multiple submenus to open -->
                <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->

                    <!-- Search Bar -->
                    <!-- <li id="search">
                        <form method="get" action="">
                            <input type="text" name="q" class="search-input" placeholder="Search something..."/>
                            <button type="submit">
                                <i class="entypo-search"></i>
                            </button>
                        </form>
                    </li> -->

                    <li class="{!! Request::is( "$accessUrl" ) ? 'active' : '' !!}">
                        <a href="{{ url( $accessUrl ) }}">
                            <i class="entypo-gauge"></i>
                            <span>{{pick_trans('menu.dash')}}</span>
                        </a>
                    </li>
                    
                    @foreach($menuItems as $url => $item)
                        @if(isset($item['sub']))
                            <li class="{{$url == $masterMenu ? 'opened active' : '' }}">
                                <a href="{{ url( $accessUrl.'/'.$url ) }}">
                                    <i class="{{$item['icon']}}"></i>
                                    <span>{{pick_trans($item['name'])}}</span>
                                </a>

                                <ul class="{{$url == $masterMenu ? 'visible' : '' }}">
                                    @foreach($item['sub'] as $subUrl => $subItem)
                                        <li class="{{$subUrl == $subMenu ? 'active' : '' }}">
                                            <a href="{{url($accessUrl.'/'.$subUrl)}}">
                                                <span>{{pick_trans($subItem['name'])}}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="{{$url == $masterMenu ? 'active' : '' }}">
                                <a href="{{url($accessUrl.'/'.$url)}}">
                                    <i class="{{$item['icon']}}"></i>
                                    <span>{{pick_trans($item['name'])}}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach

                </ul>
                <!-- main-menu Ends -->
                @endif

            </div>
            <!-- sidebar-menu Ends -->

            
            <!-- main-content Starts -->
            <div class="main-content">
        
                <div class="row" id="main-content-header">
    
                    <!-- Profile Info and Notifications -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        
                        <ul class="user-info pull-left pull-none-xsm">
                        
                            <!-- Profile Info -->
                            <li class="profile-info dropdown"><!-- add class "pull-right" if you want to place this from right -->
                                
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    @if($user['avatar'] != '')
                                        <img src="{{asset('uploads/'.$user['avatar'])}}" width="45" height="45" class="img-circle" />
                                    @else
                                        <img src="{{asset('packages/sharenjoy/cmsharenjoy/images/avatar.jpg')}}" width="45" height="45" class="img-circle" />
                                    @endif
                                    {{$user['name']}}
                                    <!-- <b class="caret"></b> -->
                                </a>
                                
                                <!-- <ul class="dropdown-menu">
                                    
                                    <li class="caret"></li>
                                    
                                    <li>
                                        <a href="#">
                                            <i class="entypo-user"></i>
                                            Edit Profile
                                        </a>
                                    </li>
                                    
                                    <li>
                                        <a href="mailbox.html">
                                            <i class="entypo-mail"></i>
                                            Inbox
                                        </a>
                                    </li>
                                    
                                    <li>
                                        <a href="extra-calendar.html">
                                            <i class="entypo-calendar"></i>
                                            Calendar
                                        </a>
                                    </li>
                                    
                                    <li>
                                        <a href="#">
                                            <i class="entypo-clipboard"></i>
                                            Tasks
                                        </a>
                                    </li>
                                </ul> -->

                            </li>
                        </ul>
                    </div>
                    
                    <!-- Raw Links -->
                    <div class="col-md-6 col-sm-4 clearfix hidden-xs">
                        <ul class="list-inline links-list pull-right">
                            <!-- <li>
                                <a href="#">Live Site</a>
                            </li>
                            <li class="sep"></li>
                            <li>
                                <a href="#" data-toggle="chat" data-animate="1" data-collapse-sidebar="1">
                                    <i class="entypo-chat"></i>
                                    Chat
                                    
                                    <span class="badge badge-success chat-notifications-badge is-hidden">0</span>
                                </a>
                            </li>
                            <li class="sep"></li> -->
                            <li>
                                <a href="{{ url( $accessUrl.'/logout' ) }}">
                                    {{pick_trans('logout')}} <i class="entypo-logout right"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- <ol class="breadcrumb bc-3">
                    <li>
                        <a href="index.html"><i class="entypo-home"></i>Home</a>
                    </li>
                    <li>
                        <a href="ui-panels.html">UI Elements</a>
                    </li>
                    <li class="active">
                        <strong>Blockquotes</strong>
                    </li>
                </ol> -->
                    
                <!-- content Starts -->
                @yield('content')
                <!-- content Ends -->

                <!-- footer Starts -->
                <footer class="main">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            &copy; {{date('Y')}} <strong>{{$brandName}}</strong>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                        
                            <ul class="list-inline links-list pull-right">
                                <li>
                                    {!!Form::select(
                                        'language', 
                                        $langLocales, 
                                        $activeLanguage,
                                        array('class'=>'form-control', 'id'=>'admin_language')
                                    )!!}
                                </li>
                                <!-- <li class="sep"></li>
                                <li>
                                    <a href="{{ url( $accessUrl.'/logout' ) }}">
                                        Log Out <i class="entypo-logout right"></i>
                                    </a>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                </footer>
                <!-- footer Ends -->
            </div>
            <!-- main-content Ends -->
        </div>
        <!-- page-container Ends -->

        <!-- Modal Starts -->
        @include('admin.partials.modal')
        @yield('modal')
        <!-- Modal Ends -->
        
        
        <script type="text/javascript">
        @section('main-scripts')
            var sharenjoy = {
                "APPURL": "{{Config::get('app.url')}}/{{$accessUrl}}/{{Session::get('onController')}}",
                "OBJURL": "{{$objectUrl}}",
                "SITEURL": "{{Config::get('app.url')}}",
                "BASEURI": "{{base_path()}}",
                "PUBLICURI": "{{public_path()}}",
                "csrf_token": "{{csrf_token()}}",
                "csrf_token_crpyt": "{{Crypt::encrypt(csrf_token())}}",
            };
            
            var opts = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-bottom-left",
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "3000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
        @show
        </script>
    
        <!-- Javascript Output Starts -->
        @include('partials.javascript-print')
        <!-- Javascript Output Ends -->
        
        <!-- Assets scripts Starts -->
        {!!Theme::asset()->scripts()!!}
        <!-- Assets scripts Ends -->
        
        <!-- Section scripts Starts -->
        @section('scripts')
        @show
        <!-- Section scripts Ends -->
        
        <!-- Final scripts Starts -->
        {!!Theme::asset()->container('final')->scripts()!!}
        <!-- Final scripts Ends -->
        
    </body>
</html>