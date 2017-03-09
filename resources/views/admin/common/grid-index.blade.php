@extends('admin.layouts.interface')

@section('title')
    {{pick_trans('manage')}}{{pick_trans($onController)}}
@stop

@section('content')

    @include('admin.partials.function')

    @include('admin.partials.messaging')
    
    @if( ! $listEmpty)
        {!!$lister!!}
    @else
        <div class="alert alert-info">
            {{pick_trans('no_item_yet')}}
        </div>
    @endif
@stop


@section('scripts')
    @parent
@stop
