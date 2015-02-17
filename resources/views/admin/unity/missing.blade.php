@extends('admin.layouts.interface')

@section('title')
404 {{pick_trans('page_not_found')}}
@stop

@section('content')
		<div class="page-error-404">
	
			<div class="error-symbol">
				<i class="entypo-attention"></i>
			</div>
		
			<div class="error-text">
				<h2>404</h2>
				<p>{{pick_trans('page_not_found')}} !</p>
			</div>
		
			<!-- <hr />
	
			<div class="error-text">
				
				Search Pages:
				
				<br />
				<br />
				
				<div class="input-group minimal">
					<div class="input-group-addon">
						<i class="entypo-search"></i>
					</div>
					
					<input type="text" class="form-control" placeholder="Search anything..." />
				</div>
				
			</div> -->
	
		</div>	
@stop

@section('scripts')
    @parent
@stop