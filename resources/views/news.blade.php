@extends('interface')

@section('title')
最新消息 | JQT
@stop

@section('styles')
@stop

@section('content')
<section class="single-project">

  <div class="single-project-intro parallax">
    <div class="intro-content">
      <div class="container">
        <h2>最新消息</h2>
      </div> <!-- /.container -->
    </div> <!-- /intro-content -->
    <div id="startchange"></div>
  </div> <!-- /.single-project-intro -->

</section> <!-- /.single-project -->

<section id="news" class="main-section" style="background-color: #fff;">
  <div class="container">

    <div class="row">
      
      @foreach($news as $item)
      <div class="col-sm-4">
        <div class="news1">
          <p class="post-date">{{$item['published_at']}}</p>
          <h3>{{$item['title']}}</h3>
          <a href="{{url('/news/'.$item['id'])}}" class="btn btn-default btn-white">詳細內容</a>
        </div>
      </div>
      @endforeach

    </div> 
  </div>
</section>

@stop

@section('scripts')
@stop

