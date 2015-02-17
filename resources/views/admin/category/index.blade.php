@extends('admin.layouts.interface')

@section('title')
    {{pick_trans('manage')}}{{pick_trans($onController)}}
@stop

@section('content')

    @include('admin.partials.function')

    @include('admin.partials.messaging')
    
    @if( ! $listEmpty)
        <div class="row">
            <div class="col-md-8">
                <div class="dataTables_wrapper">
                    <div class="row">
                        <div class="col-xs-8 col-left">
                            <div class="dataTables_length">
                                <h3>{{pick_trans('manage')}}</h3>
                            </div>
                        </div>
                        <div class="col-xs-4 col-right">
                            <div class="dataTables_filter" id="table-1_filter">
                                <!-- <label>{{pick_trans('search')}}: <input type="text" aria-controls="table-1"></label> -->
                            </div>
                        </div>
                    </div>
                    
                    <div id="list-table">
                        {!!$lister!!}
                    </div>

                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-primary" data-collapsed="0">
            
                    <div class="panel-heading">
                        <div class="panel-title">
                            {{pick_trans('please_drag')}}
                        </div>
                        
                        <div class="panel-options">
                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                        </div>
                    </div>
                    
                    <div class="panel-body">

                        <div id="list-1" class="nested-list dd with-margins">

                            <ul class="dd-list">
                                @foreach($categories as $keyOne => $valueOne)
                                <li class="dd-item" data-id="{{$valueOne['id']}}">
                                    <div class="dd-handle"> {{$valueOne['title']}} </div>
                                    
                                    @if(isset($valueOne['children']) AND count($valueOne['children']))
                                    <ul class="dd-list">
                                        @foreach($valueOne['children'] as $keyTwo => $valueTwo)
                                            <li class="dd-item" data-id="{{$valueTwo['id']}}">
                                                <div class="dd-handle"> {{$valueTwo['title']}} </div>
                                            </li>
                                        @endforeach

                                        @if(isset($valueTwo['children']) AND count($valueTwo['children']))
                                        <ul class="dd-list">
                                            @foreach($valueTwo['children'] as $keyThree => $valueThree)
                                                <li class="dd-item" data-id="{{$valueThree['id']}}">
                                                    <div class="dd-handle"> {{$valueThree['title']}} </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </ul>
                                    @endif

                                </li>
                                @endforeach
                            </ul>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            {{pick_trans('no_item_yet')}}
        </div>
    @endif
@stop


@section('scripts')
    @parent
    <script src="{{asset('packages/sharenjoy/cmsharenjoy/js/jquery.nestable.js')}}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($)
        {
            $(".dd").nestable({
                maxDepth: {{$categoryLevelNum}},
                expandBtnHTML: false,
                collapseBtnHTML: false,
            }).on('change', function(e) {
                var list = e.length ? e : $(e.target);
                var result = {};

                result = {
                    'sort_value': window.JSON.stringify(list.nestable('serialize'))
                };
                // console.log(result);

                $.post("{{$objectUrl}}/order", result)
                    .done(function(result) {
                        toastr.success(result.message, "{{pick_trans('success')}}", opts);
                    }).fail(function(result) {
                        toastr.error(result.message, "{{pick_trans('fail')}}", opts);
                    }
                );
            });
        });
    </script>
@stop
