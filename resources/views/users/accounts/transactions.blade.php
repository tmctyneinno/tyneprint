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
						<h3 class="acc-title lg">Payment Transactions</h3>
						<div class="form-edit-info">
							<table class="table-responsive data-table " id="my-orders-table">
						        <tr class="">
						            <th>Payment Ref #</th>
						            <th>External Ref</th>
						            <th class="th_hidden"><span class="nobr">Amount</span></th>
						            <th class="th_hidden"><span class="nobr">Order No</span></th>
                                     <th class="th_hidden"><span class="nobr">Date</span></th>
						            <th>&nbsp;</th>
						        </tr>
                                @if(count($transactions)>0)
                                @foreach ($transactions  as $order )
							    <tr class="">
						            <td>{{$order->payment_ref}}</td>
                                     <td>{{$order->external_ref}}</td>
                                       <td><span class="price">{{number_format($order->amount,2)}}</span></td>
                                        <td>{{$order->order_No}}</td>
						            <td><span class="nobr">{{$order->created_at->format('d/m/y h:s:a')}}</span></td>
						           
							   	</tr>
                                @endforeach
                                @else

                                <tr><td>  No data </td> </tr>
                                @endif
							</table>

                            <div style="float:right"> {{$transactions->links()}}	</div>				
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