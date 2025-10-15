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
					
					</div>
				</div>
				<!--Account top banner : End-->
				<div class="row acc-order">
					<!--Account Sidebar: End-->
							@include('includes.sidebar')
							<!--Account Sidebar: End-->
					<!--Account main content : Begin -->
				<section class="account-main col-md-9 col-sm-8 col-xs-12">
						<h3 class="acc-title lg">My Dashboard</h3>
						<div class="row db-content">
							<div class="db-hello col-xs-12">
								<div class="pad-1015">
									<p class="hello-user">
										Hello, {{$user->name}} !
									</p>
									<p class="hello-par">
										From your Account Dashboard you have the ability to view your Orders, and update your account information.
									</p>
								</div>
							</div>
							<div class="db-info col-xs-12">
								<div class="row">
									<div class="col-md-6 col-sm-6 db-contact">
										<h4 class="acc-title h-icon">
											Account information
											<a href="#" class="acc-edit" title="edit information">
												
											</a>
										</h4>
										<div class="acc-info-content pad-1015">
											<span class="name">{{$user->name}}</span>
											<span class="email">{{$user->email}}</span>
												<span class="email">{{$user->phone}}</span>
											<a href="{{route('user.account')}}" title="Change Password">Update Details</a>
										</div>
									</div>
									<div class="col-md-6 col-sm-6 db-newsletter">
										<h4 class="acc-title h-icon">
											Orders
											<a href="#" class="acc-edit" title="edit subscription">
												
											</a>
										</h4>
										<div class="acc-info-content pad-1015">
											<p>Total Order: {{$orders}}</p>
											<p>Pending Order: {{$pending}}</p>
											<span>Completed Order: {{$completed}}</span>
											<a href="{{route('user.orders')}}" title="Change Password">View Orders</a>
										</div>
									</div>
								</div>
							</div>
						
						</div>
					</section>


					<!-- Cart main content : End -->
				</div>
				
			</div>
		</section>
	</main>
	
	@endsection