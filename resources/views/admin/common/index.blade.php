@extends('admin.layouts.interface')

@section('title')
    {{pick_trans('manage')}}{{pick_trans($onController)}}
@stop

@section('content')

    @include('admin.partials.function')

    @include('admin.partials.messaging')
    
    @if( ! $listEmpty)
        <div class="row">
            <div class="col-md-12">
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
        </div>
    @else
        <div class="alert alert-info">
            {{pick_trans('no_item_yet')}}
        </div>
    @endif
@stop


@section('scripts')
    @parent
@stop
