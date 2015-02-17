@extends('admin.layouts.interface')

@section('title')
{{pick_trans('add')}}{{pick_trans($onController)}}
@stop

@section('content')

  @include('admin.partials.function')

  @include('admin.partials.messaging')

  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary" data-collapsed="0">
      
        <div class="panel-heading">
          <div class="panel-title">
              <h3>{{pick_trans('add')}}</h3>
          </div>

          <!-- <div class="panel-options pull-left">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#profile-1" data-toggle="tab">First Tab</a></li>
              <li><a href="#profile-2" data-toggle="tab">Second Tab</a></li>
            </ul>
          </div> -->
        </div>
        
        <div class="panel-body">
          <div class="tab-content">
            
            <div class="tab-pane active" id="profile-1">
              {!!Form::open(['url'=>$createUrl, 'class'=>'form-horizontal form-groups-bordered', 'role'=>'form', 'id'=>'created-form'])!!}

                @if(isset($fieldsForm) AND ! is_null($fieldsForm))
                    {!!$fieldsForm!!}
                @endif
                
                <div class="form-group">
                    <div class="col-sm-12">
                        @include('admin.partials.button-create')
                    </div>
                </div>
              {!!Form::close()!!}
            </div>
            
            <!-- <div class="tab-pane" id="profile-2">
              <strong>Entire any had depend and figure winter</strong>
              <p>Met whose marry under the merit. In it do continual consulted no listening. Devonshire sir sex motionless travelling six themselves. So colonel as greatly shewing herself observe ashamed. Demands minutes regular ye to detract is.</p>
            </div> -->

          </div>
        </div>
      </div>
    </div>
  </div>
@stop

@section('modal')
    <!-- Filemanager modal -->
    @if(Session::get('onController') != 'filer')
      
      <div class="modal fade custom-width" id="modal-filemanager">
        <div class="modal-dialog" style="width:800px">
          <div class="modal-content">
            
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">{{pick_trans('menu.file')}}</h4>
            </div>
            
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <iframe src="{{url($accessUrl.'/filer/filemanager')}}" id="iframe-modal-filemanager" width="100%" height="560" frameborder="0" scrolling="no"></iframe>
                </div>
              </div>
            </div>
            
            <div class="modal-footer">
              <input type="hidden" name="pick_field_name" id="pick_field_name" value="">
              <button type="button" class="btn btn-default" data-dismiss="modal">{{pick_trans('buttons.close')}}</button>
            </div>
          </div>
        </div>
      </div>

      @if(isset($albumId))
        <div class="modal fade custom-width" id="modal-file-album">
          <div class="modal-dialog" style="width:800px">
            <div class="modal-content">
              
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{pick_trans('menu.file')}}</h4>
              </div>
              
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    <iframe src="{{url($accessUrl.'/filer/filealbum/'.$albumId)}}" id="iframe-modal-file-album" width="100%" height="560" frameborder="0" scrolling="no"></iframe>
                  </div>
                </div>
              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{pick_trans('buttons.close')}}</button>
              </div>
            </div>
          </div>
        </div>
      @endif

    @endif
    <!-- Filemanager modal Ends -->
@stop

@section('scripts')
    @parent
@stop
