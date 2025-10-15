@extends('layouts.app')
@section('content')
<main id="main" class="account dashboard">
		<section class="header-page">
			<div class="container">
				<div class="row">
					
					<div class="breadcrumb-w col-sm-9">
						<ul class="breadcrumb">
							<li>
								<a href="{{route('index')}}">Home</a>
							</li>
							<li>
								<span>Dashboard</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</section> 
		<section class="account-content parten-bg">
			<div class="container">
				<!--Account top banner -->
				
				<div class="row">
					<div class="col-md-12 cart-banner-top hidden-xs">
					@if(Session::has('message'))
                             <span class=" alert alert-{{Session::get('alert')}}">{{Session::get('message')}}</span>
                                @endif
                @error('password')
                   <span class="alert alert-danger"> {{$message}} </span>
                @enderror
					</div>
				</div>
				<!--Account top banner : End-->
				<div class="row acc-order">
					<!--Account Sidebar: End-->
					@include('includes.sidebar')
					<!--Account Sidebar: End-->
		
					<!--Account main content : Begin -->
					<section class="account-main col-md-9 col-sm-8 col-xs-12">
						<h3 class="acc-title lg">Edit Account Information</h3>
						<div class="form-edit-info">
							<h4 class="acc-sub-title">Account Information</h4>
							  {{Form::open(['action' => 'App\Http\Controllers\HomeController@updateDetails', 'method'=>'post'])}}
                              @csrf
								<div class="form-group">
								    <label for="first-name">First Name<span class="required">*</span></label>
									<input type="text" name="name" class="form-control" id="first-name" value="{{$user->name}}">
								</div>
								<div class="form-group">
								    <label for="email">Email Address<span class="required">*</span></label>
									<input type="text" class="form-control" id="email" value="{{$user->email}}" readOnly>
								</div>
                                <div class="form-group">
								    <label for="email">Phone Number<span class="required">*</span></label>
									<input type="text" class="form-control" id="email" value="{{$user->phone}}" readOnly>
								</div>
								 <div class="form-group">
								    <label for="password">Current Password<span class="required">*</span></label>
								<input id="current-pwd" class="form-control @error('OldPassword') is-invalid @enderror "name="oldPassword" placeholder="Current Password"
									type="password" placeholder="xxxxxxxxxxxxxxxxxxxx"></div>
                                 <div class="form-group">
								    <label for="password">New Password<span class="required">*</span></label>
								<input id="new-pwd" type="password"  class="form-control @error('password') is-invalid @enderror" name="password" placeholder="New Password"
								type="password" ></div>
                                 <div class="form-group">
								    <label for="password">Confirm Password<span class="required">*</span></label>
								<input id="confirm-pwd" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Confirm Password"
								type="password" ></div>
								<div class="account-bottom-action">
									<a href="#" class="back"><i class="fa fa-chevron-left"></i> Back</a>
									<button type="submit" class="gbtn btn-edit-acc-info">Update Information</button>
								</div>
							</form>
						</div>
					</section><!-- Cart main content : End -->
				</div>
				
			</div>
		</section>


					<!-- Cart main content : End -->
				</div>
				
			</div>
		</section>
	</main>
	
	@endsection