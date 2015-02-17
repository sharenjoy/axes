@extends('admin.layouts.interface')

@section('title')
{{pick_trans($onController)}}
@stop

@section('content')
    
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
                    <div class="panel-body">
                        
                        @include('admin.partials.messaging')
                        
                        <div class="row">
                            
                            <div class="col-md-12">
                            
                                <!-- available classes "bordered", "right-aligned" -->
                                <ul class="nav nav-tabs bordered">
                                  @foreach($items as $key => $item)
                                    <li @if($key == 'general')class="active"@endif>
                                        <a href="#{{$key}}" data-toggle="tab">
                                            <span class="visible-xs"><i class="entypo-home"></i></span>
                                            <span class="hidden-xs">{{pick_trans('setting.'.$key)}}</span>
                                        </a>
                                    </li>
                                  @endforeach
                                </ul>
                                
                                <div class="tab-content">
                                    
                                    @foreach($items as $key => $item)
                                    @if($key == 'general')
                                    <div class="tab-pane active" id="{{$key}}">
                                    @else
                                    <div class="tab-pane" id="{{$key}}">
                                    @endif
                                            
                                        {!!Form::open(array('url'=>$objectUrl, 'class'=>'form-horizontal form-groups-bordered', 'role'=>'form', 'id'=>'item-form'))!!}
                                            
                                            @foreach($item['item'] as $value)
                                            <div class="form-group setting-input">
                                                <div class="col-sm-5 col-md-5">
                                                    <p>{!!Form::label($value->key, pick_trans('setting.label.'.$value->key), array('class'=>'control-label'))!!}</p>

                                                    @if ($value->type == 'text')
                                                        {!!Form::text(
                                                            $value->key, 
                                                            $value->value, 
                                                            array('class'=>'form-control', 'data-id'=>$value->id)
                                                        )!!}
                                                    @elseif ($value->type == 'textarea')
                                                        {!!Form::textarea(
                                                            $value->key, 
                                                            $value->value, 
                                                            array('class'=>'form-control', 'rows'=>'3', 'data-id'=>$value->id)
                                                        )!!}
                                                    @elseif ($value->type == 'select')
                                                        {!!Form::select(
                                                            $value->key, 
                                                            trans_options($value->key),
                                                            $value->value,
                                                            array('class'=>'form-control', 'data-id'=>$value->id)
                                                        )!!}
                                                    @elseif ($value->type == 'radio')
                                                        @foreach (Config::get('options.'. $value->key) as $optionKey => $optionValue)
                                                            <div class="radio"><label>
                                                            @if ($value->value == $optionKey)
                                                                {!!Form::radio($value->key, $optionKey, true)!!}
                                                            @else
                                                                {!!Form::radio($value->key, $optionKey)!!}
                                                            @endif
                                                            {{pick_trans($optionValue)}}&nbsp;&nbsp;
                                                            </label></div>
                                                        @endforeach
                                                    @elseif ($value->type == 'checkbox')
                                                        @foreach (Config::get('options.'. $value->key) as $optionKey => $optionValue)
                                                            <?php
                                                                $options = explode(',', $value->value);
                                                            ?>
                                                            <div class="checkbox"><label>
                                                            @if (in_array($optionKey, $options))
                                                                {!!Form::checkbox($value->key, $optionKey, true)!!}
                                                            @else
                                                                {!!Form::checkbox($value->key, $optionKey)!!}
                                                            @endif
                                                            {{pick_trans($optionValue)}}&nbsp;&nbsp;
                                                            </label></div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="col-sm-7 col-md-7">
                                                    <span class="help-block">{{pick_trans('setting.description.'.$value->key)}}</span>
                                                </div>
                                            </div>
                                            @endforeach

                                        {!!Form::close()!!}
                                
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')
    @parent

    <script>

        $(function(){

            function ajax_post_save(send_data) {
                // console.log(send_data);
                send_data._token = sharenjoy.csrf_token;

                $.post(sharenjoy.APPURL + "/store", send_data)
                    .done(function(result) {
                        toastr.success(result.message, "{{pick_trans('success')}}", opts);
                    }).fail(function(result) {
                        toastr.error(result.message, "{{pick_trans('fail')}}", opts);
                    }
                );
            }
            
            var $activeTag;

            $('.setting-input input[type=text], .setting-input textarea').on('focusin', function (e) {
                e.preventDefault();

                $activeTag = $(this);
                $active = $(this).parent();
                
                // console.log($active.find('div')['length']);
                if ($active.find('div')['length'] == 0) {
                    $active.append('<div style="margin-top:5px;">{!!$buttons!!}</div>');
                };
            });

            $('.setting-input input[type=text], .setting-input textarea').on('focusout', function (e) {
                e.preventDefault();

                $activeTag = $(this);
                $active = $(this).parent();

                $active.find('div').fadeOut(function(){
                    $(this).remove();
                });
            });

            $('.setting-input').delegate('button[class="btn btn-reset"]', 'click', function (e) {
                e.preventDefault();
                
                $activeTag.val($activeTag[0]['defaultValue']);

                $(this).parent().fadeOut(function(){
                    $(this).remove();
                });
            });

            $('.setting-input').delegate('button[class="btn btn-success btn-save"]', 'click', function (e) {
                e.preventDefault();

                var send_data = {};

                send_data = {
                    'item': $activeTag.attr('name'),
                    'type': $activeTag[0]['type'],
                    'value': $activeTag.val()
                };

                ajax_post_save(send_data);

                $(this).parent().fadeOut(function(){
                    $(this).remove();
                });
            });

            $('.setting-input input[type=checkbox]').on('change', function (e) {
                e.preventDefault();

                var send_data = {};
                $active = $(this);

                send_data = {
                    'item': $active.attr('name'),
                    'type': 'checkbox',
                    'value': $active.parent().parent().parent().find('input[type="checkbox"]').serialize()
                };

                ajax_post_save(send_data);
            });

            $('.setting-input input[type=radio]').on('change', function (e) {
                e.preventDefault();

                var send_data = {};
                $active = $(this);

                send_data = {
                    'item': $active.attr('name'),
                    'type': 'radio',
                    'value': $active.val()
                };

                ajax_post_save(send_data);
            });

            $('.setting-input select').on('change', function (e) {
                e.preventDefault();

                var send_data = {};
                $active = $(this);

                send_data = {
                    'item': $active.attr('name'),
                    'type': 'select',
                    'value': $active.val()
                };

                ajax_post_save(send_data);
            });

        });

    </script>
@stop
