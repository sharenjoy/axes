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
        
        <div class="panel-body" id="clone-section">
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
    @include('admin.common.modal')
@stop

@section('scripts')
    @parent
@stop
