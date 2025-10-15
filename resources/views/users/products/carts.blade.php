@extends('layouts.app')

@section('content')
<main id="main" class="cart">
    <section class="header-page">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 hidden-xs">
                    <h1 class="mh-title">Shopping Cart</h1>
                </div>
                <div class="breadcrumb-w col-sm-9">
                    <ul class="breadcrumb">
                        <li><a href="{{ route('index') }}">Home</a></li>
                        <li><span>Shopping Cart</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="cart-content parten-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12 cart-banner-top hidden-xs"></div>
            </div>

            <div class="row cart-header hidden-xs">
                <div class="col-md-6 col-sm-10 cart-title">
                    <h1>Shopping Cart ({{ count($carts) }})</h1>
                </div>
                <div class="col-md-3 col-sm-2 continue-shopping">
                    <a href="{{ route('index') }}" title="Continue shopping">
                        Continue Shopping <i class="fa fa-arrow-circle-o-right"></i>
                    </a>
                </div>
            </div>

            @if(Session::has('message'))
                <div class="alert alert-success mt-3">
                    {{ Session::get('message') }}
                </div>
            @endif

            @if(count($carts) > 0)
                <div class="row">
                    <!-- Cart main content -->
                    <section class="cart-main col-md-8 col-xs-12">
                        <p class="visible-xs mobile-cart-title">
                            There are {{ count($carts) }} items in your cart.
                        </p>

                        <div class="table-responsive">
                            <table class="table-cart table">
                                <thead class="hidden-xs">
                                    <tr>
                                        <th class="product-info">Products</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-quantity">Qty</th>
                                        <th class="product-subtotal">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carts as $cart)
                                        <tr class="cart_item">
                                            <td class="product-info"> 
                                                <div class="product-image-col">
                                                    <a class="product-image" title="{{ $cart->name }}">
                                                        @php
                                                            $attributes = $cart->attributes ?? [];
                                                            $images = isset($attributes['images']) && is_array($attributes['images'])
                                                                ? $attributes['images']
                                                                : [];
                                                            $imagePath = count($images) > 0
                                                                ? asset('images/products/' . $images[0])
                                                                : asset('frontend/images/cart/product-card.jpg');
                                                        @endphp
                                                        <img src="{{ $imagePath }}" alt="{{ $cart->name }}">
                                                    </a>

                                                    <div class="product-action hidden-sm">
                                                        <form action="{{ route('carts.destroy', $cart->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="cart-delete btn btn-link text-danger p-0" title="Remove from Cart">
                                                                <i class="fa fa-times"></i> Remove
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>

                                                <div class="product-info-col">
                                                    <h3 class="product-name">{{ $cart->name }}</h3>
                                                    @if(!empty($cart->attributes['description']))
                                                        <p class="small text-muted">{{ $cart->attributes['description'] }}</p>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="product-price hidden-xs">
                                                <span>₦{{ number_format($cart->price, 2) }}</span>
                                            </td>

                                            <td class="product-quantity hidden-xs">
                                                <form action="{{ route('carts.update', encrypt($cart->id)) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <select class="form-control" name="qty" onchange="this.form.submit()">
                                                        @if(!empty($cart->attributes['pricelist']))
                                                            @foreach ($cart->attributes['pricelist'] as $qty)
                                                                <option value="{{ $qty['qty'] }}" {{ $cart->quantity == $qty['qty'] ? 'selected' : '' }}>
                                                                    {{ $qty['qty'] }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                    <input type="hidden" name="rowId" value="{{ $cart->id }}">
                                                </form>
                                            </td>

                                            <td class="product-subtotal hidden-xs">
                                                <span>₦{{ number_format($cart->price * $cart->quantity, 2) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                        <div class="row update-wishlist">
                            <div class="col-sm-12 hidden-xs text-right">
                                <strong>TOTAL: </strong>
                                <button type="button" class="gbtn btn-update-wishlist btn btn-warning">
                                    ₦{{ number_format(\Cart::getTotal(), 2) }}
                                </button>
                            </div>
                        </div>
                    </section>

                    <!-- Cart Summary -->
                    <section class="col-sm-4 row cart-bottom">
                        <div class="subtotal">
                            <form action="{{ route('checkout.index') }}" method="GET">
                                <h3>Cart Summary</h3>
								@php 
									$subTotal = \Cart::getSubTotal();
									$taxRate = 0.075; // 7.5% tax example
									$tax = $subTotal * $taxRate;
									$shipment = 0; // or your shipping logic
									$total = $subTotal + $tax + $shipment;
								@endphp  
                                <ul>
                                    <li>
                                        <span class="sub-title">Sub Total</span>
                                        <span class="sub-value">₦{{ number_format($subTotal, 2) }}</span>
                                    </li>
                                    <li>
                                        <span class="sub-title">Tax</span>
                                        <span class="sub-value">
											₦{{ number_format($tax, 2) }}
										</span>
                                    </li>
                                    <li class="grand-total">
                                        <span class="sub-title">Grand Total</span>
                                        <span class="sub-value">₦{{ number_format($total, 2) }}</span>
                                    </li>
                                </ul>
                                <button type="submit" class="btn btn-primary w-100 mt-3">
                                    Proceed to Checkout
                                </button>
                            </form>
                        </div>
                    </section>
                </div>
            @else
                <div class="col-12 text-center py-5">
                    <img src="{{ asset('/frontend/images/empty.png') }}" alt="Empty Cart" class="mb-3">
                    <h5 style="color:#fed700;">Your Cart is Empty</h5>
                    <p>Click <a href="{{ route('index') }}">Here to Start Shopping</a></p>
                </div>
            @endif
        </div>
    </section>
</main>
@endsection
