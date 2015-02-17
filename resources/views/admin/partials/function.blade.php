<div class="row">
  <div class="col-md-12">
    <div class="sorted">
      <div class="panel panel-primary" data-collapsed="0">

        <!-- panel head -->
        <div class="panel-heading">
            <div class="panel-title">
                <h3>{{pick_trans($onController)}}</h3>
            </div>
            <div class="panel-options">
                <!-- <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> -->
                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                <!-- <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> -->
                <!-- <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> -->
            </div>
        </div>
        
        <!-- panel body -->
        <div class="panel-body fun-box">
        
            @if(isset($functionRules['list']) AND $functionRules['list'] == true)
                @if(Session::has('goBackPrevious') AND Session::get('onAction') != 'index' AND Session::get('onAction') != 'sort')
                <div class="pull-left">
                    <a href="{{Session::get('goBackPrevious')}}" class="btn btn-info btn-icon icon-left">
                        <i class="fa fa-arrow-left"></i>{{pick_trans('buttons.return')}}
                    </a>
                </div>
                @endif

                <div class="pull-left">
                    <a href="{{$objectUrl}}" class="btn btn-default btn-icon icon-left">
                        <i class="fa fa-bars"></i>{{pick_trans('buttons.list')}}
                    </a>
                </div>
            @endif

            @if(isset($functionRules['create']) AND $functionRules['create'] == true)
            <div class="pull-left">
                <a href="{{$createUrl}}" class="btn btn-default btn-icon icon-left">
                    <i class="fa fa-plus"></i>{{pick_trans('buttons.new')}}
                </a>
            </div>
            @endif
            
            @if(isset($functionRules['order']) AND $functionRules['order'] == true)
            <div class="pull-left">
                <a href="{{$sortUrl}}" class="btn btn-default btn-icon icon-left">
                    <i class="fa fa-sort"></i>{{pick_trans('buttons.sort')}}
                </a>
            </div>
            @endif

        </div>

        @if(isset($filterForm) AND ! is_null($filterForm))
        <div class="panel-body filter-box">
            {!!Form::open(array('url'=>$objectUrl, 'role'=>'form', 'method'=>'GET'))!!}
                <div class="row">

                    {!!$filterForm!!}

                    <div class="list-filter col-md-3 col-sm-6">
                        {!!Form::hidden('filter', 'true')!!}
                        {!!Request::has('perPage') ? Form::hidden('perPage', Request::query('perPage')) : ''!!}
                        {!!Form::label('')!!}<br>
                        {!!Form::submit(pick_trans('buttons.filter'), array('class'=>'btn btn-blue'))!!}
                    </div>

                </div>
            {!!Form::close()!!}
        </div>
        @endif

      </div>

    </div>
  </div>
</div>
