@extends('admin.layouts.login')

@section('title')
{{pick_trans('forgot_password')}} - {{$brandName}}
@stop

@section('content')

    {!!Form::open(array('url'=>$accessUrl.'/remindpassword', 'method'=>'POST', 'role'=>'form'))!!}
                    
        @include('admin.partials.messaging')

        <div class="form-group">
            
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="entypo-user"></i>
                </div>
                
                {!!Form::text('email', Input::old('email'), array('placeholder'=>pick_trans('insert_email'), 'class'=>'form-control'))!!}
            </div>
            
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block btn-login">
                <i class="entypo-login"></i>
                {{pick_trans('buttons.continue')}}
            </button>
        </div>

        <div class="form-group">
            <a href="{{url($accessUrl.'/login')}}" class="link">{{pick_trans('back_login')}}</a>
        </div>
                     
    {!!Form::close()!!}

@stop