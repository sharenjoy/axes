@extends('interface')

@section('title')
JQT
@stop

@section('styles')
@stop

@section('content')
<section id="intro" class="intro-parallax parallax">
  <div class="intro-content">
    <h1>創新來自專業</h1>
    <p>駿騏科技有限公司創立核准於2012年，致力於研發及創新各項自動控制系統及節能控制系統，並可依客戶需求進行客製化程式編輯，目前已經與電子業、製造業及工程公司配合許多工程案，並且不斷創造雙贏的優勢，主要來自客戶對公司的信賴及認可公司的核心價值。</p>
    <a href="#work" class="btn btn-default">我們的實績</a>
  </div> <!-- /.intro-content -->
  <div id="startchange"></div>
</section> <!-- /#intro -->


<section id="work" class="main-section">
  <div class="container">

    <header>
      <h2>案例實績</h2>
      <p class="sub-header">完成客戶的需求，作好最佳的服務者</p>
    </header>

    <div class="work-gallery">
      <div class="row">

        <div class="col-sm-8">
          <a href="#" @click.prevent="projectClick">
            <img src="assets/images/project01.jpg" class="img-responsive" alt="" />
            <div class="work-overlay">
              <p>台積電</p>
            </div>
          </a>
        </div> <!-- /.col-sm-8 -->

        <div class="col-sm-4">
          <a href="#" @click.prevent="projectClick">
            <img src="assets/images/project06.jpg" class="img-responsive" alt="" />
            <div class="work-overlay">
              <p>台積電</p>
            </div>
          </a>
        </div> <!-- /.col-sm-4 -->
      </div> <!-- /.row -->

      <div class="row">
        <div class="col-sm-4">
          <a href="#" @click.prevent="projectClick">
            <img src="assets/images/project05.jpg" class="img-responsive" alt="" />
            <div class="work-overlay">
              <p>京元電子</p>
            </div>
          </a>
        </div> <!-- /.col-sm-4 -->

        <div class="col-sm-8">
          <a href="#" @click.prevent="projectClick">
            <img src="assets/images/project02.jpg" class="img-responsive" alt="" />
            <div class="work-overlay">
              <p>京元電子</p>
            </div>
          </a>
        </div> <!-- /.col-sm-8 -->
      </div> <!-- /.row -->

      <div class="row">
        <div class="col-sm-8">
          <a href="#" @click.prevent="projectClick">
            <img src="assets/images/project03.jpg" class="img-responsive" alt="" />
            <div class="work-overlay">
              <p>奇美電子</p>
            </div>
          </a>
        </div> <!-- /.col-sm-8 -->

        <div class="col-sm-4">
          <a href="#" @click.prevent="projectClick">
            <img src="assets/images/project04.jpg" class="img-responsive" alt="" />
            <div class="work-overlay">
              <p>奇美電子</p>
            </div>
          </a>
        </div> <!-- /.col-sm-4 -->

      </div> <!-- /.row -->
    </div> <!-- /.work-gallery -->
  </div> <!-- /.container -->
</section> <!-- /#work -->



<section id="services" class="main-section">
  <div class="container">

    <header>
      <h2>服務項目</h2>
      <!-- <p class="sub-header">Get me a vodka rocks. And a piece of toast. I don't criticize you! And if you're worried about criticism, sometimes a diet is the best defense. Army had half a day. No, I did not kill Kitty.</p> -->
    </header>

    <div class="row">

      <div class="col-md-4 col-sm-6">
        <div class="service1">
          <i class="fa fa-microchip"></i>
          <h3>PLC架構系統可程式編輯</h3>
          <ul class="service-list">
            <li>HVAC大型空調監控系統</li>
            <li>MEP 機電整合控制及監控</li>
            <li>無塵室環境監控</li>
            <li>MAU 分散式控制系統</li>
            <li>依業主需規劃設計及製作</li>
          </ul>
        </div> <!-- /.service1 -->
      </div> <!-- /.col-md-4 -->

      <div class="col-md-4 col-sm-6">
        <div class="service1">
          <i class="fa fa-cubes"></i>
          <h3>控制電盤</h3>
          <ul class="service-list">
            <li>變頻控制盤設計及製作</li>
            <li>給排水電盤設計及製作</li>
            <li>PLC控制型電盤設計及製作</li>
            <li>依業主需規劃設計及製作</li>
          </ul>
        </div> <!-- /.service1 -->
      </div> <!-- /.col-md-4 -->

      <div class="col-md-4 col-sm-6">
        <div class="service1">
          <i class="fa fa-clone"></i>
          <h3>專利</h3>
          <ul class="service-list">
            <li>流量平衡量測調整裝置(專利:M485264)</li>
            <li>多泵給排水雙功能控制盤(專利:M471611)</li>
          </ul>
        </div> <!-- /.service1 -->
      </div> <!-- /.col-md-4 -->

      <div class="col-md-4 col-sm-6">
        <div class="service1">
          <i class="fa fa-window-restore"></i>
          <h3>SCADA圖控畫面編輯</h3>
          <ul class="service-list">
            <li>HVAC大型空調監控系統</li>
            <li>MEP 機電整合控制及監控</li>
            <li>無塵室環境監控畫面編輯</li>
            <li>原系統畫面修改</li>
            <li>依業主需規劃設計及製作</li>
          </ul>
        </div> <!-- /.service1 -->
      </div> <!-- /.col-md-4 -->

      <div class="col-md-4 col-sm-6">
        <div class="service1">
          <i class="fa fa-envira"></i>
          <h3>節能系統規劃施作</h3>
          <ul class="service-list">
            <li>空調系統水路節能規劃</li>
            <li>高效率馬達更換</li>
            <li>水路系統節能效益評估</li>
            <li>依業主需規劃設計及製作</li>
          </ul>
        </div> <!-- /.service1 -->
      </div> <!-- /.col-md-4 -->

      <div class="col-md-4 col-sm-6">
        <div class="service1">
          <i class="fa fa-users"></i>
          <h3>PLC系統客製化編輯</h3>
          <ul class="service-list">
            <li>各項產品搭配PLC控制編輯</li>
            <li>量化型生產設備搭配控制系統</li>
            <li>各項製程類設備程式規劃編輯</li>
            <li>可搭配業主溝通共同開發</li>
          </ul>
        </div> <!-- /.service1 -->
      </div> <!-- /.col-md-4 -->

    </div> <!-- /.row -->
  </div> <!-- /.container -->
</section> <!-- /#services -->



<div id="process" class="main-section">
  <div class="container">

    <header>
      <h2>公司核心價值</h2>
      <p class="sub-header">提供客戶<span class="text-danger">「專業」</span>的技術是公司的基本<br>
   提供客戶<span class="text-danger">「品質」</span>的保證是公司的信念<br>
   提供客戶<span class="text-danger">「效益」</span>的服務是我們的目標<br>
   提供客戶<span class="text-danger">「信任」</span>的價值是我們的價值</p>
    </header>

    <div class="process-line"></div>

    <div class="process-list">
      <div class="row">

        <div class="col-md-3 col-sm-6">
          <div class="process-dot"></div>
          <h4>專業</h4>
          <p>提供客戶<span class="text-danger">「專業」</span><br>的技術是公司的基本</p>
        </div> <!-- /.col-md-3 -->

        <div class="col-md-3 col-sm-6">
          <div class="process-dot"></div>
          <h4>品質</h4>
          <p>提供客戶<span class="text-danger">「品質」</span><br>的保證是公司的信念</p>
        </div> <!-- /.col-md-3 -->

        <div class="col-md-3 col-sm-6">
          <div class="process-dot"></div>
          <h4>效益</h4>
          <p>提供客戶<span class="text-danger">「效益」</span><br>的服務是我們的目標</p>
        </div> <!-- /.col-md-3 -->

        <div class="col-md-3 col-sm-6">
          <div class="process-dot"></div>
          <h4>信任</h4>
          <p>提供客戶<span class="text-danger">「信任」</span><br>的價值是我們的價值</p>
        </div> <!-- /.col-md-3 -->

      </div> <!-- /.row -->
    </div> <!-- /.process-list -->

  </div> <!-- /.container -->
</div> <!-- /#process -->


<section id="news" class="main-section">
  <div class="container">

    <header>
      <h2>最新消息</h2>
    </header>

    <div class="row">
      
      @foreach($news as $item)
      <div class="col-sm-6">
        <div class="news1">
          <p class="post-date">{{$item['published_at']}}</p>
          <h3>{{$item['title']}}</h3>
          <p class="post-text">{!!nl2br($item['description'])!!}</p>
          <a href="{{url('/news/'.$item['id'])}}" class="btn btn-default btn-white">詳細內容</a>
        </div>
      </div>
      @endforeach

    </div> 
    <div class="text-center" style="margin-top: 20px;">
      <a href="{{url('/news')}}" class="btn btn-default btn-white">更多最新消息</a>
    </div>
  </div>
</section>



<section id="contact" class="contact1 main-section">
  <div class="container">

    <header>
      <h2>聯絡我們</h2>
      <p class="sub-header">駿騏科技有限公司<br>新北市汐止區秀峰路109巷3號1樓</p>
    </header>

    <div class="contact-info">
      <ul class="list-unstyled list-inline">
        <li>
          <h5>電話</h5>
          <p>(02)2690-2036</p>
        </li>

        <li>
          <h5>傳真</h5>
          <p>(02)2690-2079</p>
        </li>

        <li>
          <h5>Email</h5>
          <p>jqt.co@msa.hinet.net</p>
          <br />
        </li>
      </ul>
    </div> <!-- /.contact-info -->

    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <form id="contactForm" data-toggle="validator" class="shake">

          <div class="form-group">
            <input type="text" class="form-control" id="name" placeholder="請輸入您的名字" required>
            <div class="help-block with-errors"></div>
          </div>

          <div class="form-group">
            <input type="email" class="form-control" id="email" placeholder="請輸入您的Email" required>
            <div class="help-block with-errors"></div>
          </div>

          <div class="form-group">
            <textarea id="message" class="form-control" rows="5" placeholder="請輸入您的訊息" required></textarea>
            <div class="help-block with-errors"></div>
          </div>

          <div class="text-center">
            <button type="submit" id="form-submit" class="btn btn-default">發送</button>
          </div>

          <div id="msgSubmit" class="h3 text-center hidden"></div>
          <div class="clearfix"></div>
        </form>
      </div> <!-- /.col-md-6 -->
    </div> <!-- /.row -->

  </div> <!-- /.container -->
</section> <!-- /#contact -->
@stop

@section('scripts')
@stop
