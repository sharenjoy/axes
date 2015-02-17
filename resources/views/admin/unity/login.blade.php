@extends('admin.layouts.login')

@section('title')
{{pick_trans('login')}} - {{$brandName}}
@stop

@section('content')

    {!! Form::open(array( 'url'=>$accessUrl.'/login' , 'method'=>'POST' , 'role'=>'form' )) !!}
                    
        @include('admin.partials.messaging')

        <div class="form-group">
            
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="entypo-user"></i>
                </div>
                
                {!! Form::text('email', Input::old('email') , array( 'placeholder'=>pick_trans('insert_account') , 'class'=>'form-control' ) ) !!}
            </div>
            
        </div>

        <div class="form-group">
            
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="entypo-key"></i>
                </div>
                
                {!! Form::password('password', array( 'placeholder'=>pick_trans('insert_password') , 'class'=>'form-control' , 'autocomplete'=>'off' ) ) !!}
                
            </div>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block btn-login">
                <i class="entypo-login"></i>
                {{pick_trans('login')}}
            </button>
        </div>

        <div class="form-group">
            <a href="{{url($accessUrl.'/remindpassword')}}">{{pick_trans('forgot_password')}} ?</a>
        </div>
        
        <!-- Implemented in v1.1.4 -->              
        
        <!-- 
        <div class="form-group">
            <em>- or -</em>
        </div>
        
        <div class="form-group">
        
            <button type="button" class="btn btn-default btn-lg btn-block btn-icon icon-left facebook-button">
                Login with Facebook
                <i class="entypo-facebook"></i>
            </button>
            
        </div>
        
        
        
        You can also use other social network buttons
        <div class="form-group">
        
            <button type="button" class="btn btn-default btn-lg btn-block btn-icon icon-left twitter-button">
                Login with Twitter
                <i class="entypo-twitter"></i>
            </button>
            
        </div>
        
        <div class="form-group">
        
            <button type="button" class="btn btn-default btn-lg btn-block btn-icon icon-left google-button">
                Login with Google+
                <i class="entypo-gplus"></i>
            </button>
            
        </div> -->              
    {!! Form::close() !!}

@stop