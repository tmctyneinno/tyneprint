@extends('layouts.app')
@section('content')
<main class="main" id="product-detail">
		<!--Breadcrumb : Begin-->
		<section class="header-page">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 hidden-xs">
						<h1 class="mh-title">Get price quote</h1>
					</div>
					<div class="breadcrumb-w col-sm-8">
						<ul class="breadcrumb">
							<li>
								<a href="{{route('index')}}">Home</a>
							</li>
							<li>
								<a href="#">Price Quote</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</section><!--Breadcrumb : End-->
		<!--Product info : Begin-->

		<section class="account-content parten-bg">
			<div class="container">
				<!--Account top banner -->
				<div class="row">
					
				</div><!--Account top banner : End-->
				<div class="row acc-dashboard">
					<!--Account Sidebar: End-->
					{{-- <aside class="col-md-2 col-sm-2 d-sm-none ">
					
					</aside><!--Account Sidebar: End--> --}}
					<!--Account main content : Begin -->
					<section class="account-main col-md-12 col-sm-12 col-xs-12">
						<h2 style="font-size:24px; font-weight:bold; padding:40px 0 20px 0px; " class="pt-4">Get Custom Print Quote Quickly.</h2>
						<div class="form-edit-info">
							<h4 class="acc-sub-title">Fill the details of your order below.</h4>
							<form  method="Post" action="{{route('price.quote')}}">
								@csrf
								<div class="form-group">
								    <label for="first-name">First Name</label>
									<input style="max-width:600px" type="text" name="first_name" value="{{old('first_name')}}" class="form-control" id="first-name" placeholder="first name" required>
								</div>
								<div class="form-group">
								    <label for="last-name">Last Name</label>
									<input style="max-width:600px" type="text"  name="last_name"  value="{{old('last_name')}}" class="form-control" id="first-name" placeholder="last name" required>
								</div>
								<div class="form-group">
								    <label for="email">Email Address</label>
									<input style="max-width:600px" type="text" name="email" class="form-control"  value="{{old('email_name')}}" id="email" placeholder="example@email.com" required>
								</div>
								<div class="form-group">
								    <label for="email">Phone Number</label>
									<input style="max-width:600px" type="text" name="phone" class="form-control"  value="{{old('phone')}}" id="email" placeholder="080343454554" required>
								</div>
								<div class="form-group">
								    <label for="email">What would you like to Print?</label>
									<textarea class="form-control"  name="message" rows="10"  value="{{old('item')}}" col="10" placeholder="What do you want to print" required>   </textarea>
								</div>

								<div class="form-group">
								    <label for="email">How about the design (Artwork)?</label> <br>
									<input type="radio" id="design" name="design" value="yes" checked> Yes, I have design 
									<input type="radio" id="design" name="design" value="no" > No, I dont have a design 
								</div>

								<div class="form-group">
								    <label for="email">Your Delivery Address</label>
									<textarea class="form-control"  value="{{old('delivery_address')}}" name="delivery_address" rows="10" col="10" placeholder="Your Delivery Address">   </textarea>
								</div>
								<div class="account-bottom-action">
									<button type="submit" class="gbtn btn-edit-acc-info" style="background:rgb(13, 160, 13); color:aliceblue">Submit Request</button>
								</div>
							</form>
						</div>
					</section><!-- Cart main content : End -->
				</div>
				
			</div>
		</section>

@endsection