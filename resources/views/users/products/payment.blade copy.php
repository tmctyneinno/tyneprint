@extends('layouts.app')

@section('content')
<main class="main">
    <section class="header-page">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 hidden-xs">
                    <h1 class="mh-title">Checkout Payment</h1>
                </div>
                <div class="breadcrumb-w col-sm-9">
                    <ul class="breadcrumb">
                        <li><a href="{{ route('index') }}">Home</a></li>
                        <li><a href="{{ route('carts.index') }}">Cart</a></li>
                        <li><span>Payment</span></li>
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
                @if(session()->has('message'))
                <div class="col-md-12 col-sm-12 col-xs-12" style="padding:20px">
                    <span class="alert alert-{{ session('alert') }}">
                        {{ session('message') }}
                    </span>
                </div>
                @endif

                <div id="login-pane" class="col-md-12 col-sm-12 col-xs-12">
                    <p>Please complete your order payment.</p>
                </div>
            </div>

            {{-- Payment Form --}}
            <div id="paymentForm">
                @csrf
                <input type="hidden" name="payment_verified" id="paymentVerified" value="0">
                <input type="hidden" name="transaction_id" id="transactionId" value="">
                <input type="hidden" name="order_number" id="orderNumber" value="{{ $order_item->order_No ?? '' }}">
               
                <div class="onepage">
                    <div class="col-md-7 col-sm-6 col-xs-12">
                        {{-- ORDER SUMMARY --}}
                        <div class="pane round-box">
                            <h3 class="title"><span class="icon icon-one">1</span>Order Summary</h3>
                            <div class="pane-inner">
                                <div class="cart-items">
                                    @foreach($carts as $item)
                                    <div class="cart-item" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee;">
                                        <div>
                                            <strong>{{ $item->name }}</strong>
                                            <br>
                                            <small>Qty: {{ $item->quantity }} × ₦{{ number_format($item->price, 2) }}</small>
                                        </div>
                                        <div>
                                            ₦{{ number_format($item->price * $item->quantity, 2) }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- SHIPPING INFORMATION --}}
                        <div class="pane round-box">
                            <h3 class="title"><span class="icon icon-one">2</span>Shipping Information</h3>
                            <div class="pane-inner">
                                <ul class="adminform user-details no-border">
                                    <li>
                                        <label>Receiver Name</label><br>
                                        <input type="text" value="{{ $address->receiver_name ?? '' }}" readonly class="form-control">
                                    </li>
                                    <li>
                                        <label>Receiver Phone</label><br>
                                        <input type="text" value="{{ $address->receiver_phone ?? '' }}" readonly class="form-control">
                                    </li>
                                    <li>
                                        <label>Address</label><br>
                                        <input type="text" value="{{ $address->address ?? '' }}, {{ $address->city ?? '' }}, {{ $address->state ?? '' }}" readonly class="form-control">
                                    </li>
                                    <li>
                                        <label>Delivery Method</label><br>
                                        <input type="text" value="{{ ucfirst(str_replace('_', ' ', $address->delivery_method ?? '')) }}" readonly class="form-control">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- PAYMENT SECTION --}}
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        {{-- PAYMENT DETAILS --}}
                        <div class="pane round-box">
                            <h3 class="title"><span class="icon icon-four">3</span>Payment Details</h3>
                            <div class="pane-inner">
                                <table class="cart-summary no-border" style="width: 100%;">
                                    <tbody>
                                        <tr>
                                            <td>Subtotal:</td>
                                            <td class="pr-right">₦{{ number_format(\Cart::getSubTotal(), 2) }}</td>
                                        </tr>

                                        @php 
                                            $tax = \Cart::getSubTotal() * 0.075;
                                            $delivery_fee = ($address->delivery_method ?? '') === 'home_delivery' ? ($fare->delivery_fee ?? 0) : 0;
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

                                <div class="mt-4">
                                    <div class="alert alert-info">
                                        <small>
                                            <i class="fa fa-info-circle"></i>
                                            You will be redirected to Flutterwave to complete your payment securely.
                                        </small>
                                    </div>
                                    
                                    <button type="button" id="payButton" onclick="makePayment()" class="btn btn-primary btn-lg w-100">
                                        <i class="fa fa-credit-card"></i> Pay Now - ₦{{ number_format($total, 2) }}
                                    </button>
                                    
                                    <div id="paymentStatus" class="mt-2" style="display: none;">
                                        <div class="alert alert-success">
                                            <i class="fa fa-check-circle"></i>
                                            <span id="statusMessage">Payment verified! Processing your order...</span>
                                        </div>
                                    </div>

                                    <div id="orderStatus" class="mt-2" style="display: none;">
                                        <div class="alert alert-info">
                                            <i class="fa fa-spinner fa-spin"></i>
                                            <span id="orderMessage">Processing your order...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('script')
<script src="https://checkout.flutterwave.com/v3.js"></script>
<script>
// Payment configuration
const paymentConfig = {
    public_key: "{{ config('app.FLUTTERWAVE_PUBLIC_KEY') }}",
    amount: {{ $total }},
    currency: "NGN",
    email: "{{ auth()->user()->email }}",
    phone: "{{ auth()->user()->phone }}",
    name: "{{ auth()->user()->name }}",
    userId: {{ auth()->id() }},
    tx_ref: "TYNE_{{ auth()->id() }}_{{ time() }}_{{ rand(1000, 9999) }}"
};

let isProcessing = false;
let paymentVerified = false;

function makePayment() {
    if (isProcessing) {
        alert('Payment is already being processed. Please wait...');
        return;
    }

    // Disable button to prevent multiple clicks
    const payButton = document.getElementById('payButton');
    payButton.disabled = true;
    payButton.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Opening Payment...';
    isProcessing = true;

    FlutterwaveCheckout({
        public_key: paymentConfig.public_key,
        tx_ref: paymentConfig.tx_ref,
        amount: paymentConfig.amount,
        currency: paymentConfig.currency,
        country: "NG",
        payment_options: "card, banktransfer, ussd, mobilemoney",
        meta: {
            consumer_id: paymentConfig.userId,
            purpose: "Order Payment"
        },
        customer: {
            email: paymentConfig.email,
            phone_number: paymentConfig.phone,
            name: paymentConfig.name
        },
        callback: function (response) {
            console.log('Flutterwave Response:', response);
            
            if (response.status === "successful") {
                // Payment was successful, verify it
                verifyPayment(response.flw_ref, response.tx_ref);
            } else {
                // Payment failed
                handlePaymentFailure(response.message || 'Payment failed. Please try again.');
            }
        },
        onclose: function() {
            // User closed the modal
            if (!paymentVerified) {
                resetPaymentButton();
            }
            console.log('Payment modal closed by user');
        }
    });
}

function verifyPayment(flw_ref, tx_ref) {
    console.log('Verifying payment:', { flw_ref, tx_ref });
    
    const payButton = document.getElementById('payButton');
    payButton.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Verifying Payment...';
    
    const statusDiv = document.getElementById('paymentStatus');
    const statusMessage = document.getElementById('statusMessage');
    
    statusMessage.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Verifying payment with bank...';
    statusDiv.style.display = 'block';

    // Send verification request to server
    fetch('{{ route("verify.payment") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            flw_ref: flw_ref,
            tx_ref: tx_ref,
            amount: paymentConfig.amount
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Verification response:', data);
        
        if (data.status === 'success') {
            // Payment verified successfully
            paymentVerified = true;
            statusMessage.innerHTML = '<i class="fa fa-check-circle"></i> Payment verified successfully!';
            statusDiv.className = 'mt-2 alert alert-success';
            
            // Update hidden fields
            document.getElementById('paymentVerified').value = '1';
            document.getElementById('transactionId').value = data.transaction_id || tx_ref;
            
            payButton.innerHTML = '<i class="fa fa-check"></i> Payment Verified!';
            
            // Now create the order via AJAX
            createOrder();
            
        } else {
            // Verification failed
            handlePaymentFailure(data.message || 'Payment verification failed. Please contact support.');
        }
    })
    .catch(error => {
        console.error('Verification error:', error);
        handlePaymentFailure('Network error during payment verification. Please check your connection and try again.');
    });
}

function createOrder() {
    console.log('Creating order via AJAX...');
    
    const orderStatusDiv = document.getElementById('orderStatus');
    const orderMessage = document.getElementById('orderMessage');
    const payButton = document.getElementById('payButton');
     
    orderMessage.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Creating your order...';
    orderStatusDiv.style.display = 'block';
    
    // Prepare form data
    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('payment_verified', document.getElementById('paymentVerified').value);
    formData.append('transaction_id', document.getElementById('transactionId').value);
    formData.append('order_number', document.getElementById('orderNumber').value);
    formData.append('total_amount', document.getElementById('totalAmount').value);

    // Send AJAX request to create order
    fetch('{{ route("checkout.storeOrder") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Order creation response:', data);
        
        if (data.success) {
            // Order created successfully
            orderMessage.innerHTML = '<i class="fa fa-check-circle"></i> ' + (data.message || 'Order created successfully! Redirecting...');
            orderStatusDiv.className = 'mt-2 alert alert-success';
            
            payButton.innerHTML = '<i class="fa fa-check"></i> Order Created!';
            
            // Redirect to success page
            setTimeout(() => {
                if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                } else {
                    window.location.href = '{{ route("order.success") }}';
                }
            }, 2000);
            
        } else {
            // Order creation failed
            handleOrderFailure(data.message || 'Order creation failed. Please contact support.');
        }
    })
    .catch(error => {
        console.error('Order creation error:', error);
        handleOrderFailure('Network error during order creation. Please check your connection.');
    });
}

function handlePaymentFailure(message) {
    const statusDiv = document.getElementById('paymentStatus');
    const statusMessage = document.getElementById('statusMessage');
    
    statusMessage.innerHTML = '<i class="fa fa-exclamation-triangle"></i> ' + message;
    statusDiv.className = 'mt-2 alert alert-danger';
    statusDiv.style.display = 'block';
    
    resetPaymentButton();
    
    // Scroll to error message
    statusDiv.scrollIntoView({ behavior: 'smooth' });
}

function handleOrderFailure(message) {
    const orderStatusDiv = document.getElementById('orderStatus');
    const orderMessage = document.getElementById('orderMessage');
    
    orderMessage.innerHTML = '<i class="fa fa-exclamation-triangle"></i> ' + message;
    orderStatusDiv.className = 'mt-2 alert alert-danger';
    orderStatusDiv.style.display = 'block';
    
    resetPaymentButton();
    
    // Scroll to error message
    orderStatusDiv.scrollIntoView({ behavior: 'smooth' });
}

function resetPaymentButton() {
    const payButton = document.getElementById('payButton');
    payButton.disabled = false;
    payButton.innerHTML = '<i class="fa fa-credit-card"></i> Pay Now - ₦{{ number_format($total, 2) }}';
    isProcessing = false;
    paymentVerified = false;
}
</script>
@endsection