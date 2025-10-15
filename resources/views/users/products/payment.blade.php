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
                            <a href="{{ route('index') }}">Home</a>
                        </li>
                        <li>
                            <span>Payment</span>
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
                
                @if(Session::has('message'))
                <div class="col-md-12 col-sm-12 col-xs-12" style="padding:20px">
                    <span class="alert alert-{{ Session::get('alert') }}"> 
                        {{ Session::get('message') }}
                        @if(Session::has('reset'))
                        <a class="btn-info" style="padding:5px" href="{{ route('password.request') }}">Reset Password</a>
                        @endif
                    </span>
                </div>
                @endif

                <div id="login-pane" class="col-md-12 col-sm-12 col-xs-12">
                    <p>Please complete Order payment.</p>
                </div>
            </div>
                            
            {{ Form::open(['action' => 'App\Http\Controllers\CheckoutController@storeOrder', 'method' => 'post', 'id' => 'form1']) }}
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
                                                @auth value="{{ auth()->user()->name }}" @endauth 
                                                value="{{ old('name') }}" 
                                                class="@error('name') is-invalid @enderror" 
                                                placeholder="Full Name" 
                                                @auth readonly @endauth> 
                                            @error('name')
                                                <span class="btn-danger" role="alert">
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
                                                value="@auth {{ auth()->user()->email }} @endauth {{ old('email') }}" 
                                                class="@error('email') is-invalid @enderror" 
                                                placeholder="Email Address" 
                                                @auth readonly @endauth>
                                            @error('email')
                                                <span class="btn-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </li>
                                    
                                    <li class="long">
                                        <div class="field-wrapper">
                                            <label for="phone_2_field" class="phone_2">Mobile phone</label>
                                            <br>
                                            <input type="text" name="phone" 
                                                @auth value="{{ auth()->user()->phone }}" @endauth 
                                                value="{{ old('phone') }}" 
                                                class="@error('phone') is-invalid @enderror" 
                                                placeholder="Phone number" 
                                                @auth readonly @endauth>
                                            @error('phone')
                                                <span class="btn-danger" role="alert">
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
                                                @if(isset($address->receiver_name)) value="{{ $address->receiver_name }}" @endif 
                                                value="{{ old('receiver_name') }}" 
                                                class="@error('receiver_name') is-invalid @enderror" 
                                                placeholder="First Name">
                                            @error('receiver_name')
                                                <span class="btn-danger" role="alert">
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
                                                @if(isset($address->receiver_email)) value="{{ $address->receiver_email }}" @endif 
                                                value="{{ old('receiver_email') }}" 
                                                class="@error('receiver_email') is-invalid @enderror" 
                                                placeholder="Email Address">
                                            @error('receiver_email')
                                                <span class="btn-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </li>

                                    <li class="short">
                                        <div class="field-wrapper">
                                            <label for="middle_name_field" class="middle_name">Phone</label>
                                            <br>
                                            <input type="text" 
                                                @if(isset($address->receiver_phone)) value="{{ $address->receiver_phone }}" @endif 
                                                name="receiver_phone"    
                                                value="{{ old('receiver_phone') }}" 
                                                class="@error('receiver_phone') is-invalid @enderror" 
                                                placeholder="Phone number">
                                            @error('receiver_phone')
                                                <span class="btn-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </li>

                                    <li class="short right">
                                        <div class="field-wrapper">
                                            <label for="zip_field" class="zip">Zip / Postal Code<em>*</em></label>
                                            <br>
                                            <input type="text" name="zip_code"   
                                                @if(isset($address->zip_code)) value="{{ $address->zip_code }}" @endif 
                                                value="{{ old('zip_code') }}"   
                                                class="@error('zip_code') is-invalid @enderror" 
                                                placeholder="Zip Code">	
                                        </div>
                                    </li>

                                    <li class="short">
                                        <div class="field-wrapper">
                                            <label for="virtuemart_city" class="virtuemart_state_id">City<em>*</em></label>
                                            <br>
                                            <input type="text" name="city"  
                                                @if(isset($address->city)) value="{{ $address->city }}" @endif 
                                                value="{{ old('city') }}"   
                                                class="@error('city') is-invalid @enderror" 
                                                placeholder="Town/City">
                                            @error('city')
                                                <span class="btn-danger" role="alert">
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
                                                @if(isset($address->state)) value="{{ $address->state }}" @endif 
                                                value="{{ old('state') }}"   
                                                class="@error('state') is-invalid @enderror" 
                                                placeholder="State">
                                            @error('state')
                                                <span class="btn-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </li>

                                    <li class="long">
                                        <div class="field-wrapper">
                                            <label for="address_1_field" class="address_1">Address 1<em>*</em></label>
                                            <br>
                                            <input type="text" name="address"
                                                @if(isset($address->address)) value="{{ $address->address }}" @endif 
                                                value="{{ old('address') }}"  
                                                class="@error('address') is-invalid @enderror"
                                                placeholder="Address">
                                            @error('address')
                                                <span class="btn-danger" role="alert">
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
                                            <input type="radio" id="home_delivery" value="home_delivery" 
                                                @if(isset($address->delivery_method) && $address->delivery_method == 'home_delivery') checked @endif 
                                                class="@error('delivery_method') is-invalid @enderror toggleM" 
                                                name="delivery_method">
                                            <label for="home_delivery">
                                                <span class="vmpayment">
                                                    <span class="vmpayment_name">Home Delivery</span>
                                                </span> 
                                            </label>
                                            <br>
                                            
                                            <p id="home_de" @if(!isset($address->delivery_method) || $address->delivery_method != 'home_delivery') hidden @endif> 
                                                This item will be delivered to
                                                {{ isset($address) ? $address->receiver_name . ', ' . $address->receiver_phone . ', ' . $address->address . ', ' . $address->city : '' }}
                                                at the shipping fee of ₦{{ isset($fare) ? number_format($fare->delivery_fee) : '0' }}
                                            </p>
                                            <br>
                                            
                                            <input type="radio" id="pickup" value="pickup" 
                                                @if(isset($address->delivery_method) && $address->delivery_method == 'pickup') checked @endif 
                                                class="@error('delivery_method') is-invalid @enderror toggleM" 
                                                name="delivery_method">
                                            <label for="pickup">
                                                <span class="vmpayment @error('delivery_method') is-invalid @enderror">
                                                    <span class="vmpayment_name">Pickup Delivery</span>
                                                </span>  
                                            </label>
                                            <br>
                                            
                                            <p id="pickup_de" @if(!isset($address->delivery_method) || $address->delivery_method != 'pickup') hidden @endif>
                                                You will visit 2nd Floor, 1 Adeola Adeoye Street, Off Olowu Street or Toyin Street,
                                                Ikeja, Lagos Nigeria to pick up your item
                                            </p>
                                            <br>
                                        </fieldset>	
                                        
                                        @error('delivery_method')
                                            <span class="btn-danger" role="alert">
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
                                            <table class="cart-summary no-border" style="width: 100%;">
                                                <tbody>
                                                    <tr>
                                                        <td>Subtotal:</td>
                                                        <td class="pr-right">₦{{ number_format(\Cart::getSubTotal(), 2) }}</td>
                                                    </tr>

                                                    @php 
                                                        $tax = \Cart::getSubTotal() * 0.075;
                                                        $delivery_fee = (isset($address->delivery_method) && $address->delivery_method === 'home_delivery') ? (isset($fare->delivery_fee) ? $fare->delivery_fee : 0) : 0;
                                                        $total = \Cart::getSubTotal() + $tax + $delivery_fee;
                                                    @endphp

                                                    <tr>
                                                        <td>Tax (7.5%):</td>
                                                        <td class="pr-right">₦{{ number_format($tax, 2) }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>Shipping:</td>
                                                        <td class="pr-right">₦{{ number_format($delivery_fee, 2) }}</td>
                                                    </tr>

                                                    <tr class="last" style="border-top: 2px solid #333;">
                                                        <td><strong>Total:</strong></td>
                                                        <td class="pr-right"><strong>₦{{ number_format($total, 2) }}</strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    
                                    <tr class="coupon-pane">
                                        <td align="right" class="border-radius-lb" colspan="6">
                                            <input id="tos" class="terms-of-service" type="checkbox" name="tos" checked>
                                            <span>Click here to read terms of service and check the box to accept them.</span>
                                            
                                            <form>
                                                <script src="https://checkout.flutterwave.com/v3.js"></script>
                                                <button type="button" onclick="makePayment()" id="btnsubmit2" class="btn btn-primary btn-lg w-100">Complete Payment</button>
                                            </form>
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </section>
    </main>
@endsection

@section('script')
<script src="https://checkout.flutterwave.com/v3.js"></script>
<script>
let total_paid = {!! json_encode($total) !!};
let fare = {!! json_encode(isset($fare->delivery_fee) ? $fare->delivery_fee : 0) !!};
let total = parseInt(total_paid) + parseInt(fare);

$('.toggleM').on('change', function(){
    if(document.getElementById('home_delivery').checked){
        $('#shipment').html('<span class="font-weight-bold">'+'₦'+thousands_separators(fare)+'</span>'); 
        $('#home_de').attr('hidden', false);
        $('#pickup_de').attr('hidden', true);
        $('#fee').attr('value', fare);
        $('#total_paid').html('₦'+thousands_separators(total)); 
    } else {
        $('#shipment').html('<span class="font-weight-bold">'+'₦0</span>'); 
        $('#pickup_de').attr('hidden', false);
        $('#fees').attr('value', 0);
        $('#total_paid').html('₦'+thousands_separators(total_paid)); 
        $('#home_de').attr('hidden', true);
    }
});

var _token = {!! json_encode(config('app.FLUTTERWAVE_PUBLIC_KEY')) !!};
let email = {!! json_encode(auth()->user()->email) !!};
let phone = {!! json_encode(auth()->user()->phone) !!};
let name = {!! json_encode(auth()->user()->name) !!};
let amounts = {!! json_encode($total) !!};

function makePayment() {
    let fee = parseInt(document.getElementById('fee')?.value || 0);
    let amounts = {!! json_encode($total) !!};
    let total_pay = amounts + fee;

    FlutterwaveCheckout({
        public_key: _token,
        tx_ref: "TNE" + Math.floor((Math.random() * 1000000) + 1),
        amount: total_pay,
        currency: "NGN",
        country: "NG",
        payment_options: "card, ussd",
        meta: {
            consumer_id: 1,
            consumer_mac: "92a3-912ba-1192a",
            purpose: "Payment for Order",
        },
        customer: {
            email: email,
            phone_number: phone,
            name: name,
        },
        callback: function (response) {
            var trx_id = response.transaction_id;
            console.log('Payment callback received:', response);
            
            $.ajax({
                url: '/payment/' + trx_id,
                method: 'get',
                success: function (response) {
                    console.log('Verification response:', response);
                    
                    // Check if payment was successful
                    if (response.data && response.data.status === 'successful') {
                        // Show loading state
                        $('#btnsubmit2').prop('disabled', true).text('Processing...');
                        
                        // Submit the form to storeOrder
                        $('#form1').submit();
                    } else {
                        alert('Payment verification failed. Please contact support.');
                        console.error('Payment failed:', response);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Verification error:', error);
                    alert('Error verifying payment. Please contact support.');
                }
            });
        },
        onclose: function() {
            // Called when modal is closed
            console.log('Payment modal closed');
        },
        customizations: {
            title: "TynePrints",
            description: "Payment for Order",
            logo: "https://tyneprints.com/frontend/images/logo.png",
        },
    });
}

function thousands_separators(num) {
    var num_parts = num.toString().split(".");
    num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return num_parts.join(".");
}

// Add form submission handler to prevent double submission
$('#form1').on('submit', function(e) {
    // Prevent double submission
    if ($(this).hasClass('submitting')) {
        e.preventDefault();
        return;
    }
    
    $(this).addClass('submitting');
    $('#btnsubmit2').prop('disabled', true).text('Creating Order...');
});
</script>
@endsection