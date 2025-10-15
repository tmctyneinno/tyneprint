@extends('layouts.app')

@section('content')
<main class="main">
    <section class="header-page">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 hidden-xs">
                    <h1 class="mh-title">Checkout</h1>
                </div>
                <div class="breadcrumb-w col-sm-9">
                    <ul class="breadcrumb">
                        <li>
                            <a href="{{route('index')}}">Home</a>
                        </li>
                        <li>
                            <span>Checkout</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="checkout" class="pr-main">
        <div class="container">    
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="cart-top"></div>
            </div>    
            
            <div class="cart-view-top">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <h1>Shopping Cart</h1>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 right">
                    <h1>Continue Shopping</h1>
                </div>
                <div id="login-pane" class="col-md-12 col-sm-12 col-xs-12">
                    <p>Please fill in the fields below to complete your order.
                    @guest
                    <a id="login-modal-trigger" href="{{route('login')}}"> Already registered? Click here to login.</a>
                    @endguest</p>
                </div>
            </div>
            @if(!empty($warningMessage))
                <div class="alert alert-warning" role="alert">
                    {{ $warningMessage }}
                </div>
            @endif

            @if(Session()->has('message'))
            <div class="col-md-12 col-sm-12 col-xs-12" style="padding:20px">
                <span class="alert alert-{{Session::get('alert')}}" role="alert"> 
                    <span style="padding:5px">{!! Session()->get('message')!!} </span>
                    @if(Session()->has('reset'))
                    <a class="btn-info" style="padding:5px" href="{{route('password.request')}}"> Reset Password </a>
                    @endif
                </span>
            </div>
            @endif        
            
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="onepage">
                    <div class="col-md-7 col-sm-6 col-xs-12">
                        <div id="div_billto">
                            <!-- user info -->
                            <div class="pane round-box">
                                <h3 class="title"><span class="icon icon-one">1</span>Customer Information</h3>
                                <div class="pane-inner">
                                    <ul id="table_billto" class="adminform user-details no-border">
                                        <li class="short">
                                            <div class="field-wrapper">
                                                <label for="company_field" class="company">Name</label>
                                                <br>
                                                <input type="text" name="name" maxlength="64" 
                                                    @auth value="{{ auth()->user()->name }}" readonly @else value="{{ old('name') }}" @endauth 
                                                    class="form-control @error('name') is-invalid @enderror" 
                                                    placeholder="Full Name">
                                                @error('name')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </li>

                                        <li class="short right">
                                            <div class="field-wrapper">
                                                <label for="email_field" class="email">Email<em>*</em></label>
                                                <br>
                                                <input type="email" name="email" 
                                                    @auth value="{{ auth()->user()->email }}" readonly @else value="{{ old('email') }}" @endauth 
                                                    class="form-control @error('email') is-invalid @enderror" 
                                                    placeholder="Email Address">
                                                @error('email')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </li>
                                        
                                        <li class="long">
                                            <div class="field-wrapper">
                                                <label for="phone_2_field" class="phone_2">Mobile phone</label><br>
                                                <input type="text" name="phone" 
                                                    @auth value="{{ auth()->user()->phone }}" readonly @else value="{{ old('phone') }}" @endauth 
                                                    class="form-control @error('phone') is-invalid @enderror" 
                                                    placeholder="Phone number">
                                                @error('phone')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- end of user info -->
                            
                            <div class="pane round-box">
                                <h3 class="title"><span class="icon icon-one">2</span>SHIPPING INFORMATION</h3>
                                <div class="pane-inner">
                                    <ul id="table_billto" class="adminform user-details no-border">
                                        <li class="short">
                                            <div class="field-wrapper">
                                                <label for="company_field" class="company">Name</label>
                                                <br>
                                                <input type="text" name="receiver_name" 
                                                    value="{{ isset($address->receiver_name) ? $address->receiver_name : old('receiver_name') }}" 
                                                    class="form-control @error('receiver_name') is-invalid @enderror" 
                                                    placeholder="Receiver Name">
                                                @error('receiver_name')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </li>

                                        <li class="short right">
                                            <div class="field-wrapper">
                                                <label for="email_field" class="email">E-Mail<em>*</em></label>
                                                <br>
                                                <input type="email" name="receiver_email" 
                                                    value="{{ isset($address->receiver_email) ? $address->receiver_email : old('receiver_email') }}" 
                                                    class="form-control @error('receiver_email') is-invalid @enderror" 
                                                    placeholder="Receiver Email Address">
                                                @error('receiver_email')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </li>

                                        <li class="short">
                                            <div class="field-wrapper">
                                                <label for="middle_name_field" class="middle_name">Phone</label>
                                                <br>
                                                <input type="text" name="receiver_phone" 
                                                    value="{{ isset($address->receiver_phone) ? $address->receiver_phone : old('receiver_phone') }}" 
                                                    class="form-control @error('receiver_phone') is-invalid @enderror" 
                                                    placeholder="Receiver Phone number">
                                                @error('receiver_phone')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </li>

                                        <li class="short right">
                                            <div class="field-wrapper">
                                                <label for="zip_field" class="zip">Zip / Postal Code<em>*</em></label><br>
                                                <input type="text" name="zip_code" 
                                                    value="{{ isset($address->zip_code) ? $address->zip_code : old('zip_code') }}" 
                                                    class="form-control @error('zip_code') is-invalid @enderror" 
                                                    placeholder="Zip Code">
                                                @error('zip_code')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </li>

                                        <li class="short">
                                            <div class="field-wrapper">
                                                <label for="virtuemart_city" class="virtuemart_state_id">City<em>*</em></label>
                                                <br>
                                                <input type="text" name="city" 
                                                    value="{{ isset($address->city) ? $address->city : old('city') }}" 
                                                    class="form-control @error('city') is-invalid @enderror" 
                                                    placeholder="Town/City">
                                                @error('city')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </li>

                                        <li class="short right">
                                            <div class="field-wrapper">
                                                <label for="virtuemart_state_id_field" class="virtuemart_state_id">State<em>*</em></label>
                                                <br>
                                                <input type="text" name="state" 
                                                    value="{{ isset($address->state) ? $address->state : old('state') }}" 
                                                    class="form-control @error('state') is-invalid @enderror" 
                                                    placeholder="State">
                                                @error('state')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </li>

                                        <li class="long">
                                            <div class="field-wrapper">
                                                <label for="address_1_field" class="address_1">Address 1<em>*</em></label><br>
                                                <input type="text" name="address" 
                                                    value="{{ isset($address->address) ? $address->address : old('address') }}" 
                                                    class="form-control @error('address') is-invalid @enderror" 
                                                    placeholder="Address">
                                                @error('address')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <div id="right-pane-top" class="col-md-12 col-sm-12 col-xs-12">    
                            <div id="payment_method" class="col-md-12 col-sm-12 col-xs-12">
                                <div class="payment-pane">
                                    <div class="pane round-box">
                                        <h3 class="title">
                                            <span class="icon icon-four">3</span>
                                            Delivery Method
                                        </h3>
                                        <div class="pane-inner">
                                            Select Delivery method
                                            <fieldset id="payments">
                                                <div class="form-check">
                                                    <input type="radio" id="home_delivery" value="home_delivery" 
                                                        class="form-check-input @error('delivery_method') is-invalid @enderror" 
                                                        name="delivery_method" {{ old('delivery_method') == 'home_delivery' ? 'checked' : '' }}>
                                                    <label for="home_delivery" class="form-check-label">
                                                        <span class="vmpayment">
                                                            <span class="vmpayment_name">Home Delivery</span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" id="pickup" value="pickup" 
                                                        class="form-check-input @error('delivery_method') is-invalid @enderror" 
                                                        name="delivery_method" {{ old('delivery_method') == 'pickup' ? 'checked' : '' }}>
                                                    <label for="pickup" class="form-check-label">
                                                        <span class="vmpayment">
                                                            <span class="vmpayment_name">Pickup</span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </fieldset>    
                                            @error('delivery_method')
                                                <span class="text-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="checkfull" class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <fieldset class="round-box" id="cart-contents">
                                    <h3 class="title"><span class="icon fa fa-check"></span>ORDER DETAILS</h3>
                                    <table cellspacing="0" cellpadding="0" border="0" class="cart-summary no-border">
                                        <tr class="pr-total">
                                            <td colspan="1">
                                                <table>       
                                                    @php
                                                        $subTotal = \Cart::getSubTotal();
                                                        $taxRate = 0.075; // 7.5% tax example
                                                        $tax = $subTotal * $taxRate;
                                                        $shipment = 0; // or your shipping logic
                                                        $total = $subTotal + $tax + $shipment;
                                                    @endphp                      
                                                    <tbody>
                                                        <tr class="first">
                                                            <td>SubTotal:</td>
                                                            <td class="pr-right">
                                                                <div class="PricesalesPrice vm-display vm-price-value">
                                                                    <span class="PricesalesPrice">₦{{ number_format($subTotal, 2) }}</span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tax:</td>
                                                            <td class="pr-right"><span id="total_tax" class="priceColor2">₦{{ number_format($tax, 2) }}</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Shipment:</td>
                                                            <td class="pr-right"><span id="shipment" class="priceColor2">₦{{ number_format($shipment, 2) }}</span></td>
                                                        </tr>
                                                        <tr class="last">
                                                            <td>Total:</td>
                                                            <td class="pr-right"><strong id="bill_total">₦{{ number_format($total, 2) }}</strong></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr class="coupon-pane">
                                            <td align="right" class="border-radius-lb" colspan="6">
                                                <div class="form-check mb-3">
                                                    <input id="tos" class="form-check-input terms-of-service" type="checkbox" name="tos" required>
                                                    <label for="tos" class="form-check-label">
                                                        Click here to read terms of service and check the box to accept them.
                                                    </label>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-lg w-100">Proceed to Payment</button>
                                            </td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>
@endsection