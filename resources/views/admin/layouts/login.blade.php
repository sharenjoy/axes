<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="{{asset(Config::get('cmsharenjoy.logo.favicon.path'))}}">
    
    <meta http-equiv="expires" content="-1">
    <meta name="robots" content="none">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    
    <title>@yield('title')</title>
    
    @section('styles')
    <link rel="stylesheet" href="{{asset('packages/sharenjoy/cmsharenjoy/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css')}}">
    <link rel="stylesheet" href="{{asset('packages/sharenjoy/cmsharenjoy/css/font-icons/entypo/css/entypo.css')}}">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="{{asset('packages/sharenjoy/cmsharenjoy/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('packages/sharenjoy/cmsharenjoy/css/neon-core.css')}}">
    <link rel="stylesheet" href="{{asset('packages/sharenjoy/cmsharenjoy/css/neon-theme.css')}}">
    <link rel="stylesheet" href="{{asset('packages/sharenjoy/cmsharenjoy/css/neon-forms.css')}}">
    <link rel="stylesheet" href="{{asset('packages/sharenjoy/cmsharenjoy/css/skins/white.css')}}">
    <link rel="stylesheet" href="{{asset('packages/sharenjoy/cmsharenjoy/css/sharenjoy/custom.css')}}">
    @show

    <script src="{{asset('packages/sharenjoy/cmsharenjoy/js/jquery-1.11.0.min.js')}}"></script>

    <!--[if lt IE 9]><script src="{{asset('packages/sharenjoy/cmsharenjoy/js/ie8-responsive-file-warning.js')}}"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    
</head>
<body class="page-body login-page login-form-fall skin-white">

<div class="login-container">
    
    <div class="login-logo">
        <a href="{{url('admin')}}" class="logo">
            <img src="{{asset(Config::get('cmsharenjoy.logo.login.path'))}}" width="{{Config::get('cmsharenjoy.logo.login.width')}}" alt="" />
        </a>
    </div>
    
    <!-- <div class="login-progressbar">
        <div></div>
    </div> -->
    
    <div class="login-form">
        
        <div class="login-content">
            
            <div class="form-login-error">
                <h3>Invalid login</h3>
                <p>Enter <strong>demo</strong>/<strong>demo</strong> as login and password.</p>
            </div>
            
            @yield('content')
            
            <!-- <div class="login-bottom-links">
                
                <a href="extra-forgot-password.html" class="link">Forgot your password?</a>
                
                <br />
                
                <a href="#">ToS</a>  - <a href="#">Privacy Policy</a>
                
            </div> -->
            
        </div>
        
    </div>
    
</div>

<!-- Javascript Output Starts -->
@include('partials.javascript-print')
<!-- Javascript Output Ends -->

<!-- Bottom Scripts -->
@section('scripts')
    <script src="{{asset('packages/sharenjoy/cmsharenjoy/js/gsap/main-gsap.js')}}"></script>
    <script src="{{asset('packages/sharenjoy/cmsharenjoy/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js')}}"></script>
    <script src="{{asset('packages/sharenjoy/cmsharenjoy/js/bootstrap.js')}}"></script>
    <script src="{{asset('packages/sharenjoy/cmsharenjoy/js/joinable.js')}}"></script>
    <script src="{{asset('packages/sharenjoy/cmsharenjoy/js/resizeable.js')}}"></script>
    <script src="{{asset('packages/sharenjoy/cmsharenjoy/js/neon-api.js')}}"></script>
    <script src="{{asset('packages/sharenjoy/cmsharenjoy/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('packages/sharenjoy/cmsharenjoy/js/neon-login.js')}}"></script>
    <script src="{{asset('packages/sharenjoy/cmsharenjoy/js/neon-custom.js')}}"></script>
@show

</body>
</html>
