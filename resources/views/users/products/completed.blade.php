@extends('layouts.app')
@section('content')
<main id="main" class="account dashboard">
		<section class="header-page">
			<div class="container">
				<div class="row">
					<div class="col-sm-3 hidden-xs">
						<h1 class="mh-title">My Account</h1>
					</div>
					<div class="breadcrumb-w col-sm-9">
						<ul class="breadcrumb">
							<li>
								<a href="{{route('index')}}">Home</a>
							</li>
							<li>
								<span>Payment Completed</span>
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
						@if(Session()->has('message'))
								<span class="alert alert-success"> 
								{{Session()->get('message')}}
								</span>
								@endif
					</div>
				</div><!--Account top banner : End-->
				<div class="row acc-order">
					<!--Account Sidebar: End-->
						@include('includes.sidebar')
						<!--Account Sidebar: End-->
					<!--Account main content : Begin -->
					<section class="account-main col-md-9 col-sm-8 col-xs-12">
						<h3 class="acc-title lg">Order Details</h3>
						<div class="form-edit-info">

						<p class="mb-0">Order No: {{$order->order_No}}</p>
							<p class="mb-0">Payment Ref: {{$order->payment_ref}}</p>
							<p class="mb-0">Payment Method: {{$order->payment_method}}</p>
							<p class="mb-0">Amount Paid: ₦{{number_format($order->amount,2)}}</p>
							<p class="mb-0">Date Ordered: {{$order->created_at->format('d/M/Y H:i:s')}}</p>
							<hr>

						</div>

						<h3 class="acc-title lg">Items in this Order</h3>
						<div class="form-edit-info">
					
						  @foreach ($order_items as $items)
						  
							<div class="col-md-2 col-sm-2 col-xs-12">
							<a href=""><img src="{{asset('')}}/frontend/image/products/product-2.jpg" width="100px" height="50px" alt=""></a>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-12">
							{{$items->product_name}}<br>
							Order No: {{$items->order_No}}<br>
							Price: ₦{{number_format($items->price,2)}}<br>
							QTY: {{$items->qty}}<br>
							</div>
                          @endforeach
						</div>
						<h3 class="acc-title lg">Shipping Details</h3>
						<div class="form-edit-info">
						   Receiver Name: {{$shipping->receiver_name}}<br>
							Receiver Email: {{$shipping->receiver_email}}<br>
							Receiver Phone: {{$shipping->receiver_phone}}<br>
							Receiver Address: {{$shipping->address}}<br>
							Receiver City: {{$shipping->city}}<br>
							Receiver State: {{$shipping->state}}<br>
								@if($shipping->zip_code) Receiver Zipcode: {{$shipping->zip_code}}<br> @endif

						</div>
							<h3 class="acc-title lg">Payment Details</h3>
					<div class="form-edit-info">
					Amount: ₦{{number_format($transaction->amount,2)}}<br>
					Payment Ref: {{$transaction->payment_ref}}<br>
					External Ref: {{$transaction->external_ref}}<br>
					Payment Status:<span class=" btn-primary" style="padding:2px"> Completed</button> <br>
					</div>

					<h3 class="acc-title lg">Design Request</h3>
					<div class="form-edit-info">
					@foreach ($order_items as  $design)
					@php
					$kk  = json_decode($design->design_image, true);
					@endphp
					
					<div class="row">
					@foreach ($kk  as $value )
					<div class="col-md-4 col-sm-4 col-xs-12">
					<a href=""><img src="{{asset('/images/products/'.$value)}}" width="80%" height="200px" alt=""></a>
					</div>
					@endforeach
					</div>
					
					@endforeach
					<p style="font-size:20px; padding-top:20px; color:blue"> Description:</p>
					 {{$design->description}}<br>
					 <br>
					</div>
					</section>
					<!-- Cart main content : End -->
				</div>
				
			</div>
		</section>
	</main>
	
	@endsection