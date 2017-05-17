@extends('interface')

@section('title')
{{$item['title']}}-最新消息 | JQT
@stop

@section('styles')
@stop

@section('content')
<section class="single-project">

  <div class="single-project-intro parallax">
    <div class="intro-content">
      <div class="container">
        <h2>{{$item['title']}}</h2>
        <p>{!!nl2br($item['description'])!!}</p>
      </div> <!-- /.container -->
    </div> <!-- /intro-content -->
    <div id="startchange"></div>
  </div> <!-- /.single-project-intro -->

  <div class="single-project-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-10">
          {!!$item['content']!!}
        </div> <!-- /.col-md-10 -->

        <div class="col-sm-2">
          <div class="single-project-info">
            <ul class="list-unstyled">
              <!-- <li>
                <h5>Client</h5>
                <p>Google</p>
              </li>

              <li>
                <h5>Type</h5>
                <p>Web design and development</p>
              </li> -->

              <li>
                <h5>消息日期</h5>
                <p>{{$item['published_at']}}</p>
              </li>
            </ul>
          </div> <!-- /.single-project-info -->
        </div> <!-- /.col-md-2 -->
      </div> <!-- /.row -->

    </div> <!-- /.container -->
  </div> <!-- /.single-project-content -->


</section> <!-- /.single-project -->

@stop

@section('scripts')
@stop

