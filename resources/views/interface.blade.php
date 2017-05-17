<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

  <title>@yield('title')</title>

  <!-- Favicon -->
  <link href="{{url('assets/favicon.ico')}}" rel="shortcut icon" />
  <link href="{{url('assets/apple-touch-icon.png')}}" rel="apple-touch-icon" />

  <!-- Fonts -->
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,400italic' rel='stylesheet' type='text/css' />
  <link href="{{url('assets/vendor/font-awesome-4.7.0/css/font-awesome.min.css')}}" rel="stylesheet" />

  <!-- CSS -->
  <link href="{{url('assets/vendor/bootstrap-3.3.6/css/bootstrap.min.css')}}" rel="stylesheet" />
  <link href="{{url('assets/vendor/vanillabox/theme/sweet/vanillabox.css')}}" rel="stylesheet" />
  <link href="{{url('assets/vendor/swiper-3.3.1/css/swiper.min.css')}}" rel="stylesheet" />
  <link href="{{url('assets/vendor/pushy-1.0.0/css/pushy.css')}}" rel="stylesheet" />
  <link href="{{url('assets/css/style0107.css')}}" rel="stylesheet" />

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>

<div id="vue-app">
<nav class="navbar navbar-default navbar-fixed-top" id="nav1">
  <div class="container">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="current navbar-brand" href="/"><img src="{{url('assets/images/logo.png')}}" width="250" alt="JQT"></a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="{{url('/#intro')}}">首頁</a></li>
        <li><a href="{{url('/#work')}}">案例實績</a></li>
        <li><a href="{{url('/#services')}}">服務項目</a></li>
        <!-- <li><a href="{{url('/#about')}}">關於我們</a></li> -->
        <li><a href="{{url('/#news')}}">最新消息</a></li>
        <li><a href="{{url('/#contact')}}">聯絡我們</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


@yield('content')


<footer>
  <div class="container">
    <div class="row">

      <div class="col-md-4 col-sm-6">
        <h5>創新來自專業</h5>
        <p>駿騏科技有限公司創立核准於2012年，致力於研發及創新各項自動控制系統及節能控制系統，並可依客戶需求進行客製化程式編輯，目前已經與電子業、製造業及工程公司配合許多工程案，並且不斷創造雙贏的優勢，主要來自客戶對公司的信賴及認可公司的核心價值。</p>
      </div> <!-- /.col-md-8 -->

      <div class="col-md-3 col-md-offset-3 col-sm-3">
        <h5>聯絡我們</h5>
        <p>Email<br>jqt.co@msa.hinet.net</p>
        <p>電話: (02)2690-2036<br>傳真: (02)2690-2079</p>
        <p>新北市汐止區秀峰路109巷3號1樓</p>
      </div> <!-- /.col-md-2 -->

      <div class="col-md-2 col-sm-3">
        <h5>Page</h5>
        <ul class="list-unstyled">
          <li><a href="{{url('/#work')}}">案例實績</a></li>
          <li><a href="{{url('/#services')}}">服務項目</a></li>
          <!-- <li><a href="{{url('/#about')}}">關於我們</a></li> -->
          <li><a href="{{url('/#news')}}">最新消息</a></li>
          <li><a href="{{url('/#contact')}}">聯絡我們</a></li>
        </ul>
      </div> <!-- /.col-md-2 -->

    </div> <!-- /.row -->

    <p class="copyright">&copy; {{date('Y')}} Copyright JQT</p>
  </div> <!-- /.container -->
</footer>
</div>

<script src="{{url('assets/js/jquery-1.11.3.min.js')}}"></script>
<script src="{{url('assets/vendor/bootstrap-3.3.6/js/bootstrap.min.js')}}"></script>
<script src="{{url('assets/js/jquery.parallax-1.1.3.js')}}"></script>
<script src="{{url('assets/vendor/pushy-1.0.0/js/pushy.min.js')}}"></script>
<script src="{{url('assets/vendor/swiper-3.3.1/js/swiper.min.js')}}"></script>
<script src="{{url('assets/vendor/vide-0.5.0/jquery.vide.min.js')}}"></script>
<script src="{{url('assets/js/jquery.smoothscroll.min.js')}}"></script>
<script src="{{url('assets/vendor/vanillabox/jquery.vanillabox.js')}}"></script>
<script src="{{url('assets/vendor/jquery-match-height-0.7.0/jquery.matchHeight-min.js')}}"></script>
<script src="{{url('assets/contact-form/js/validator.min.js')}}"></script>
<script src="{{url('assets/contact-form/js/form-scripts.js')}}"></script>
<!-- <script src="{{url('assets/js/map.js')}}"></script> -->
<script src="{{url('assets/js/vantage.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.3/vue.js')}}"></script>

<script>

new Vue({

  el: "#vue-app",

  methods: {
    projectClick: function () {
      //
    }
  }
});

var mySwiper = new Swiper ('.swiper-container', {
  // Optional parameters
  loop: true,

  // If we need pagination
  pagination: '.swiper-pagination',

  // Navigation arrows
  nextButton: '.swiper-button-next',
  prevButton: '.swiper-button-prev',

  // And if we need scrollbar
  scrollbar: '.swiper-scrollbar',
})
</script>
</body>
</html>
