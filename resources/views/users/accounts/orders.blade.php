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
						<h3 class="acc-title lg">My Orders</h3>
						<div class="form-edit-info">
							<table class="table-responsive data-table " id="my-orders-table">
						        <tr class="">
						            <th>Order #</th>
						            <th>Date</th>
						            <th>Ship To</th>
						            <th class="th_hidden"><span class="nobr">Order Total</span></th>
						            <th class="th_hidden"><span class="nobr">Payment status</span></th>
									      <th class="th_hidden"><span class="nobr">Completion Status</span></th>
                                     <th class="th_hidden"><span class="nobr">Delivery Status</span></th>
						            <th>&nbsp;</th>
						        </tr>
                                @if(count($orders)>0)
                                @foreach ($orders  as $order )
							    <tr class="">
						            <td>{{$order->order_No}}</td>
						            <td><span class="nobr">{{$order->created_at->format('d/m/y h:s:a')}}</span></td>
						            <td>{{$order->shipping->receiver_name}}</td>
						            <td><span class="price">{{number_format($order->amount,2)}}</span></td>
                                     <td class="th_hidden ">
                                     @if($order->is_paid == 1)
                                     <span class="btn-success btn-sm"> <em>Paid</em> </span>
                                     @else 
                                   <span class="btn-light btn-sm"> <em>pending</em></span>
                                    @endif
                                    </td>
                                    <td>
                                    <a href="#">@if($order->dispatch_status == 1) <span  class="btn-primary btn-sm">Dispatched</span> 
                                     @elseif($order->dispatch_status == 2) <span class="btn-success btn-sm">Delivered</span>
                                    @else <span  class="btn btn-outline-info">Pending</span>@endif</a>
                                    </td> 
									 <td>
                                     <a href="#">@if($order->is_delivered == 1) <span  class="btn-info btn-sm">Initiated</span>
                                    @elseif($order->is_delivered == 2) <span  class="btn-success btn-sm">Completed</span>
                                    @elseif($order->is_delivered == 3) <span  class="btn-danger btn-smr">Cancelled</span>
                                    @else <span class="btn-light btn-sm">Pending</span> @endif</a>
                                    </td>
						            <td class="th_hidden a-center last">
						                <span class="nobr">
						                	<a href="{{route('user.order-details', $order->order_No)}}">View Order</a>
							                <span class="separator">
							            </span>
							        </td>
							   	</tr>
                                @endforeach
                                @else

                                <tr><td>  No data </td> </tr>
                                @endif
							</table>

                            <div style="float:right"> {{$orders->links()}}	</div>				
						</div>
					</section>
            
            	</div>
				
			</div>
		</section>


					<!-- Cart main content : End -->
				</div>
				
			</div>
		</section>
	</main>
	
	@endsection