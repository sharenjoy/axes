@extends('admin.layouts.login')

@section('title')
{{pick_trans('reset_password')}} - {{$brandName}}
@stop

@section('content')

    {!! Form::open(array( 'url'=>$accessUrl.'/resetpassword' , 'method'=>'POST' , 'role'=>'form' )) !!}
                    
        @include('admin.partials.messaging')

        <div class="form-group">
            
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="entypo-key"></i>
                </div>
                
                {!!Form::text('email', '', array('placeholder'=>pick_trans('insert_email'), 'class'=>'form-control'))!!}
            </div>
            
        </div>

        <div class="form-group">
            
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="entypo-key"></i>
                </div>
                
                {!! Form::password('password' , array( 'placeholder'=>pick_trans('insert_reset_password') , 'class'=>'form-control' ) ) !!}
            </div>
            
        </div>

        <div class="form-group">
            
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="entypo-key"></i>
                </div>
                
                {!! Form::password('password_confirmation' , array( 'placeholder'=>pick_trans('insert_confirm_password') , 'class'=>'form-control' ) ) !!}
            </div>
            
        </div>
        
        <div class="form-group">
            {!!Form::hidden('code', $code)!!}
            <button type="submit" class="btn btn-primary btn-block btn-login">
                <i class="entypo-login"></i>
                {{pick_trans('buttons.reset')}}
            </button>
        </div>

        <div class="form-group">
            <a href="{{url($accessUrl.'/login')}}" class="link">{{pick_trans('back_login')}}</a>
        </div>
                     
    {!! Form::close() !!}

@stop