<?php
namespace App\Http\Controllers;

use App\Models\AdminNotify;
use App\Models\User;
use App\Models\Shipping;
use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\CheckoutRequest;
use App\Traits\CheckoutStore;
use App\Traits\decryptId;
use App\Models\Order;
use App\Mail\UserMail;
use App\Mail\OrderMail;
use App\Mail\PaymentMail;
use App\Models\Delivery;
use Illuminate\Support\Facades\Mail;
use App\Models\Transaction;
use App\Models\OrderItem;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Session\Session;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    use CheckoutStore;
    use decryptId;
    private $user;
    private $OrderItem;
    private $Order;
    private $Shipping;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function send($data){
        // Mail::to($data['email'])->send(new UserMail($data));
    }
    
    public function sendMail($data){
        // Mail::to($data['email'],  'orders@tyneprints.com')->send(new PaymentMail($data));
    }
    public function OrderMail($data){
        // Mail::to($data['email'], 'orders@tyneprints.com')->send(new OrderMail($data));
    }

     public function __construct()
     {
         $this->User = new User();
         $this->OrderItem = new OrderItem();
         $this->Order = new Order();
         $this->Shipping = new Shipping();
         $this->API_Token = config('app.FLUTTERWAVE_SECRET_KEY');
     }
    public function getCustomerLocation($address){
        $key = 'AIzaSyCHsIJX1EHXN_tLXbQ75pMHcB60L3XVOeU';
        $url = "https://maps.google.com/maps/api/geocode/json?key=$key&address=".urlencode($address);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Add timeout
        $responseJson = curl_exec($ch);
        $curl_error = curl_error($ch); // Get any cURL errors
        curl_close($ch);

        // Check for cURL errors first
        if ($curl_error) {
            \Log::error('Geocoding API cURL error: ' . $curl_error . ' for address: ' . $address);
            return [
                'success' => false,
                'error' => 'Failed to connect to geocoding service',
                'lat' => null,
                'lng' => null
            ];
        }

        $response = json_decode($responseJson, true);
        
        if (!$response) {
            \Log::error('Geocoding API invalid JSON response for address: ' . $address);
            return [
                'success' => false,
                'error' => 'Invalid response from geocoding service',
                'lat' => null,
                'lng' => null
            ];
        }

        if ($response['status'] == 'OK' && !empty($response['results'])) {
            return [
                'success' => true,
                'lat' => $response['results'][0]['geometry']['location']['lat'],
                'lng' => $response['results'][0]['geometry']['location']['lng'],
                'error' => null
            ];
        } else {
            // Log the specific error for debugging
            \Log::warning('Geocoding API returned status: ' . $response['status'] . ' for address: ' . $address);
            
            return [
                'success' => false,
                'error' => 'Address not found: ' . $response['status'],
                'lat' => null,
                'lng' => null
            ];
        }
    }

     
     public function getShippingPrice($lan, $lng){
        // dd($shipping);
        $shipping =  Shipping::where('user_id', auth()->user()->id)->latest()->first();
       
        $host = "https://api.gokada.ng/api/developer/order_create/";
        $data = array(
            'api_key' => "HJqbXNrycOO8tgehrmWqKrTOUKg65njvF6NDfd385TwGtvpq60CuGwelSRBt_test",
            'delivery_latitude' => '6.594770',
            'delivery_longitude' => '3.344280',
            'delivery_name' => 'Tyneprints',
            'delivery_phone' => '+2348039366207',
            'delivery_address' => '1 adeolad adeoye street ikeja',
            'pickup_address' => $shipping->address.','.$shipping->city,
            'pickup_name' => $shipping->receiver_name,
            'pickup_phone' => '+234'.$shipping->receiver_phone,
            'pickup_latitude' => $lan,
            'pickup_longitude' => $lng,
        );
        $curl  = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $host,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
        ));
        $response = curl_exec($curl);
        
        $res  = json_decode($response,true);
        if(isset($res['order_id'])){
        
        Delivery::create([
            'delivery_id' => $res['order_id'],
            'user_id' => auth()->user()->id,
            'shipping_id' => $shipping->id,
            'delivery_fee' => $res['fare'],
            'distance' => $res['distance'],
            'time' => $res['time'],
            'status' => 'pending'
            ]);
     }else{
         Delivery::create([
            'delivery_id' => null,
            'user_id' => auth()->user()->id,
            'shipping_id' => $shipping->id,
            'delivery_fee' => 0,
            'distance' => null,
            'time' => null,
            'status' => 'pending'
            ]);
         
    return redirect()->back();
     }
    }
    public function index()
    {  
        if(count(\Cart::getContent())> 0){ 
            if(auth()->user()){
                $address = Shipping::where('user_id', auth()->user()->id)->latest()->first();
                
                if($address) {
                    $geo = $this->getCustomerLocation($address->address.','.$address->city);
                    
                    if($geo['success']) {
                        // Update coordinates if geocoding was successful
                        Shipping::where('user_id', auth()->user()->id)->latest()
                                ->update([
                                    'lat' => $geo['lat'],
                                    'lng' => $geo['lng']
                                ]);
                    } else {
                        // Handle the case where geocoding failed
                        \Log::warning('Could not geocode address for user ' . auth()->user()->id . ': ' . $geo['error']);
                        // You can set a session flash message here if you want to notify the user
                        session()->flash('geo_warning', 'We could not verify your address location. Delivery estimates may be affected.');
                    }
                }
            } else {
                $address = '';
            }
            
            return view('users.products.checkout')
                    ->with('title', 'Checkout')
                    ->with('address', $address)
                    ->with('carts', \Cart::getContent());
        } else {
            return view('users.products.carts')
                    ->with('title', 'Cart')
                    ->with('carts', \Cart::getContent());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function generatePassword($request){
        $pp = substr($request,0,5);
        $nm = rand(1111,9999).rand(1111,9999);
        $password = $pp.$nm;
        return $password;
    }

    public function store(CheckoutRequest $request)
    {
        if(count(\Cart::getContent())>0){
            $valid = $request->validated();   
            
            // Handle guest checkout
            if(!auth()->user()){
                DB::beginTransaction();
                try{
                    $user = User::where('email', $request->email)->first();
                    if($user){
                        Session()->flash('alert', 'danger');
                        Session()->flash('reset');
                        Session()->flash('message', 'Opps!, The Customer email already exist on our System, Did you forget your Password?');
                        return redirect()->back()->withInput($valid);
                    } else {
                        #================== CREATE NEW USER ACCOUNT================
                        $pass = $this->generatePassword($request->name);
                        $request['pass'] = Hash::make($pass);
                        $uu = $this->createUser($request);
                    
                        #============= LOGIN USER =========================
                        Auth::login($user = $this->User->create($uu));    
                        
                        if($uu){
                            $title = 'New Customer Registered';
                            $message = 'Thanks for registrating on our system, do enjoy our services.';
                            #============== SEND REGISTRATION DETAILS TO USE =======================
                            $this->sendNotify($title, $message);
                            $data = [
                                'name' => $request->name,
                                'email' => $request->email,
                                'phone' => $request->phone,
                                'password' => $pass,
                            ];
                            $this->send($data);
                        }
                    }
                    DB::commit();
                } catch(\Exception $e){
                    DB::rollBack();
                    throw $e;
                }
            }
            
            DB::beginTransaction();
            $user = User::where('id', auth()->user()->id)->first();
            
            try{
                $order_No = rand(1111111,9999999).rand(1111111,9999999);
                $cart = \Cart::getContent();
                
                foreach($cart as $carts){
                    $order_item = new OrderItem;
                    $order_item->user_id = $user->id;
                    $order_item->product_name = $carts->model->name;
                    $order_item->order_No = $order_No;
                    $order_item->price = $carts->price;
                    $order_item->qty = $carts->qty;
                    $order_item->image = $carts->model->image;
                    $order_item->design_image = json_encode($carts->attributes->images);
                    $order_item->design_fee = $carts->attributes->design_fee;
                    $order_item->description = $carts->attributes->description;
                    $order_item->save(); 
                }
                
                $address = Shipping::where('user_id', $user->id)->latest()->first();
                if(!$address){
                    $user_address = $this->StoreShippingAddress($request);
                    $ss = $this->Shipping->create($user_address); 
                }
                DB::commit();
            } catch(\Exception $e){
                DB::rollBack();
                throw $e;
            }       
            
            $address = Shipping::where('user_id', $user->id)->latest()->first();
            
            // Handle geocoding with proper error handling
            $geo_success = false;
            $geo_error = null;
            
            if($address) {
                $geo = $this->getCustomerLocation($address->address.','.$address->city);
                
                if($geo['success']) {
                    $geo_success = true;
                    // Update coordinates in database
                    Shipping::where('user_id', auth()->user()->id)->latest()
                            ->update([
                                'lat' => $geo['lat'],
                                'lng' => $geo['lng']
                            ]);
                    
                    // Calculate shipping price with valid coordinates
                    $shipping_price = $this->getShippingPrice($geo['lat'], $geo['lng']);
                } else {
                    $geo_success = false;
                    $geo_error = $geo['error'];
                    \Log::warning('Geocoding failed for user ' . auth()->user()->id . ': ' . $geo_error);
                    
                    // Set default coordinates or use fallback method
                    $default_lat = 6.5244; // Default Lagos coordinates
                    $default_lng = 3.3792;
                    
                    Shipping::where('user_id', auth()->user()->id)->latest()
                            ->update([
                                'lat' => $default_lat,
                                'lng' => $default_lng
                            ]);
                    
                    // Calculate shipping with default coordinates
                    $shipping_price = $this->getShippingPrice($default_lat, $default_lng);
                    
                    // Show warning to user
                    Session()->flash('geo_warning', 'We could not verify your exact address location. Delivery estimates are based on general area pricing.');
                }
            } else {
                \Log::error('No shipping address found for user: ' . auth()->user()->id);
                Session()->flash('alert', 'warning');
                Session()->flash('message', 'Shipping address not found. Please add your shipping address.');
                return redirect()->back();
            }
            
            $fare = Delivery::where('user_id', auth()->user()->id)->latest()->first();
            
            // If fare calculation failed, set a reasonable default
            if(!$fare) {
                \Log::warning('Delivery fare calculation failed for user: ' . auth()->user()->id);
                
                // Create a default delivery record
                $fare = Delivery::create([
                    'delivery_id' => null,
                    'user_id' => auth()->user()->id,
                    'shipping_id' => $address->id,
                    'delivery_fee' => 1500, // Default delivery fee in cents/kobo
                    'distance' => null,
                    'time' => null,
                    'status' => 'pending'
                ]);
                
                Session()->flash('alert', 'warning');
                Session()->flash('message', 'Delivery fee estimated. Please confirm with support.');
            }
            
            return view('users.products.payment')
                ->with('user', $user)
                ->with('address', $address)
                ->with('carts', $cart)
                ->with('fare', $fare)
                ->with('geo_success', $geo_success)
                ->with('geo_error', $geo_error)
                ->with('title', 'Checkout Payment');
        } else {
            Session()->flash('alert', 'warning');
            Session()->flash('message', 'Your cart is empty. Please add items to cart before checkout.');
            return redirect()->route('carts.index');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function show($order_id = null)
    {
        if ($order_id) {
            $order = Order::where('order_No', $order_id)->orWhere('id', $order_id)->first();
        } else {
            $order = Order::where('user_id', auth()->id())->latest()->first();
        }
        
        if (!$order) {
            Session()->flash('alert', 'danger');
            Session()->flash('message', 'Order not found');
            return redirect()->route('home');
        }
        
        $shipping = Shipping::where('order_No', $order->order_No)->first();
        $order_items = OrderItem::where('order_No', $order->order_No)->get();
        $transaction = Transaction::where(['order_No' => $order->order_No, 'type' => 'debit'])->first();
        
        return view('users.products.completed')
            ->with('order', $order)
            ->with('shipping', $shipping)
            ->with('order_items', $order_items)
            ->with('transaction', $transaction)
            ->with('title', 'Order Completed');
    }

    public function completed($order_id = null)
    {
        if ($order_id) {
            $order = Order::where('order_No', $order_id)->orWhere('id', $order_id)->first();
        } else {
            $order = Order::where('user_id', auth()->id())->latest()->first();
        }
        
        if (!$order) {
            Session()->flash('alert', 'danger');
            Session()->flash('message', 'Order not found');
            return redirect()->route('home');
        }
        
        $shipping = Shipping::where('order_No', $order->order_No)->first();
        $order_items = OrderItem::where('order_No', $order->order_No)->get();
        $transaction = Transaction::where(['order_No' => $order->order_No, 'type' => 'debit'])->first();
        
        return view('users.products.completed')
            ->with('order', $order)
            ->with('shipping', $shipping)
            ->with('order_items', $order_items)
            ->with('transaction', $transaction)
            ->with('title', 'Order Completed');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    public function addNew(){
        //dd('aj jere');
        return view('users.products.edit')
                ->with('title', 'Checkout')
                ->with('user', User::where('id', auth()->user()->id)->first())
                ->with('carts', \Cart::getContent());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function Add(CheckoutRequest $request){
       //  dd($request);
        $user_address =  $this->StoreShippingAddress($request);
        $ss= $this->Shipping->create($user_address);
        if(count(\Cart::getContent())>0){
        $address = Shipping::where('user_id', auth()->user()->id)->latest()->first();
            return view('users.products.payment')
                ->with('title', 'Checkout')
                ->with('address', $address)
                ->with('user', User::where('id', auth()->user()->id)->first())
                ->with('carts', \Cart::getContent());
        }else{

            return redirect()->route('carts.index');
        }
     }
    public function update(Request $request, $id)
    {
        $id = $this->decryptId($id);
        $address = Shipping::where('id', $id)->first();
        $address->receiver_name = $request->receiver_name;
        $address->receiver_phone = $request->receiver_phone;
        $address->receiver_email = $request->receiver_email;
        $address->address = $request->address;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->zip_code = $request->zip_code;
        $address->save();
        Session()->flash('message', 'Address Updated');
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function verify($trxref)
    {
        \Log::info('=== START Payment Verification ===');
        \Log::info('Transaction Reference: ' . $trxref);

        $trnx_ref_exists = Transaction::where(['external_ref' => $trxref])->first();
        if ($trnx_ref_exists) {
            \Log::warning('Transaction already exists with external_ref: ' . $trxref);
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction Already Exist'
            ]);
        }

        $cURLConnection = curl_init();
        curl_setopt($cURLConnection, CURLOPT_URL, 'https://api.flutterwave.com/v3/transactions/'.$trxref.'/verify/');
        curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer ".$this->API_Token
        ));
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($cURLConnection, CURLOPT_TIMEOUT, 30);
        $se = curl_exec($cURLConnection);
        $curl_error = curl_error($cURLConnection);
        curl_close($cURLConnection);  
        
        if ($curl_error) {
            \Log::error('Flutterwave verification cURL error: ' . $curl_error . ' for reference: ' . $trxref);
            return response()->json([
                'status' => 'error',
                'message' => 'Connection error while verifying transaction'
            ], 500);
        }
        
        $resp = json_decode($se, true);

        if (!$resp || !is_array($resp)) {
            \Log::error('Invalid Flutterwave response for reference: ' . $trxref . ' Response: ' . $se);
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid response from payment gateway'
            ], 500);
        }

        if ($resp['status'] == 'error') {
            \Log::error('Flutterwave API error for reference: ' . $trxref . ' Message: ' . ($resp['message'] ?? 'Unknown error'));
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction not found, Please contact support'
            ]);
        }

        if (!isset($resp['data']['customer']['email']) || !isset($resp['data']['amount'])) {
            \Log::error('Missing required data in Flutterwave response for reference: ' . $trxref, $resp);
            return response()->json([
                'status' => 'error',
                'message' => 'Incomplete transaction data received'
            ], 500);
        }

        $chargeResponsecode = $resp['status'];
        $chargeAmount = $resp['data']['amount'];
        $custemail = $resp['data']['customer']['email'];
        $external_ref = $resp['data']['flw_ref'];
        $payment_ref = $resp['data']['tx_ref'];

        \Log::info('Flutterwave transaction details:', [
            'email' => $custemail,
            'amount' => $chargeAmount,
            'external_ref' => $external_ref,
            'payment_ref' => $payment_ref,
            'status' => $chargeResponsecode
        ]);

        if (($chargeResponsecode == "success")) {   
            
            // Try to find user with the original email first
            $getUser = User::where('email', $custemail)->first();
            
            // If not found, check if it's a Flutterwave test email and extract the real email
            if (!$getUser) {
                $originalEmail = $this->extractOriginalEmail($custemail);
                if ($originalEmail && $originalEmail !== $custemail) {
                    $getUser = User::where('email', $originalEmail)->first();
                    \Log::info('Extracted original email: ' . $originalEmail . ' from Flutterwave email: ' . $custemail);
                }
            }
            
            // If still not found, try case-insensitive search
            if (!$getUser) {
                $getUser = User::where('email', 'like', $custemail)->first();
            }
            
            // If still not found, try with the authenticated user (for checkout flow)
            if (!$getUser && auth()->check()) {
                $getUser = User::find(auth()->user()->id);
                \Log::info('Using authenticated user for transaction: ' . $getUser->email);
            }

            if (!$getUser) {
                \Log::error('User not found for email: ' . $custemail . ' in transaction: ' . $trxref);
                return response()->json([
                    'status' => 'error',
                    'message' => 'User account not found for this transaction. Please contact support.'
                ], 404);
            }

            try {
                DB::beginTransaction();
                
                $transactionRef = 'TNE-'.rand(1111111, 9999999);
                $ownerNewBalance = $getUser->wallet + $chargeAmount;
                
                // Update user wallet
                User::where(['id' => $getUser->id])->update(['wallet' => $ownerNewBalance]);
                
                // Create credit transaction (payment received)
                Transaction::create([
                    'user_id' => $getUser->id,
                    'payment_ref' => $transactionRef,
                    'type' => 'credit',
                    'payment_method' => 'card',
                    'external_ref' => $external_ref,
                    'amount' => $chargeAmount,
                    'prev_balance' => $getUser->wallet,
                    'avail_balance' => $ownerNewBalance 
                ]);
                
                DB::commit();
                
                \Log::info('Payment verified successfully for user: ' . $getUser->id . ' Amount: ' . $chargeAmount . ' Reference: ' . $trxref);
                
                // Return success response - this will trigger the form submission in your JavaScript
                return response()->json($resp);
                
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Database error during transaction verification: ' . $e->getMessage() . ' for reference: ' . $trxref);
                
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to process transaction'
                ], 500);
            }
        } else {
            \Log::warning('Transaction verification failed for reference: ' . $trxref . ' Status: ' . $chargeResponsecode);
            return response()->json($resp);
        }
    }

    private function extractOriginalEmail($flutterwaveEmail)
    {
        // Pattern for Flutterwave test emails: starts with ravesb_ followed by hash_ then the real email
        if (preg_match('/^ravesb_[a-f0-9]+_(.+)$/i', $flutterwaveEmail, $matches)) {
            return $matches[1]; // Return the original email part
        }
        
        // Alternative pattern if the above doesn't work
        if (strpos($flutterwaveEmail, 'ravesb_') === 0) {
            $parts = explode('_', $flutterwaveEmail, 3); // Split into max 3 parts
            if (count($parts) >= 3) {
                return $parts[2]; // The third part should be the original email
            }
        }
        
        return $flutterwaveEmail; // Return original if no pattern matched
    }

    public function storeOrder(Request $request)
    {    
        \Log::info('=== START storeOrder ===');
        
        // Check if user is authenticated
        if (!auth()->user()) {
            \Log::error('User not authenticated in storeOrder');
            Session()->flash('alert', 'danger');
            Session()->flash('message', 'User not authenticated');
            return redirect()->route('login');
        }
        
        \Log::info('User authenticated: ' . auth()->user()->id);
        
        $order_list = DB::table('order_items')->where(['user_id' => auth()->user()->id])->orderBy('created_at', 'desc')->first();
        
        // Check if order items exist
        if (!$order_list) {
            \Log::error('No order items found for user: ' . auth()->user()->id);
            Session()->flash('alert', 'danger');
            Session()->flash('message', 'No order items found');
            return redirect()->route('checkout.index');
        }
        
        \Log::info('Order items found with order_No: ' . $order_list->order_No);
        
        $transactions = Transaction::where('user_id', auth()->user()->id)->latest()->first();
        
        // Check if transaction exists
        if (!$transactions) {
            \Log::error('No transaction found for user: ' . auth()->user()->id);
            Session()->flash('alert', 'danger');
            Session()->flash('message', 'Transaction not found');
            return redirect()->route('checkout.index');
        }
        
        \Log::info('Transaction found with payment_ref: ' . $transactions->payment_ref . ', amount: ' . $transactions->amount);
        
        // Store cart content for logging before clearing
        $cartContent = \Cart::getContent();
        $cartCount = count($cartContent);
        \Log::info('Cart has ' . $cartCount . ' items before processing');
        
        if ($cartCount == 0) {
            \Log::warning('Cart is empty in storeOrder');
            Session()->flash('alert', 'danger');
            Session()->flash('message', 'Order Expired');
            return redirect()->back()->with('error', 'Order Expired');
        }
        
        // Check if order already exists
        $existing_order = Order::where('order_No', $order_list->order_No)->first();
        if ($existing_order) { 
            \Log::warning('Order already exists with order_No: ' . $order_list->order_No);
            Session()->flash('alert', 'danger');
            Session()->flash('message', 'Order Already Exist, close window');
            return redirect()->route('checkout.index')->with('errors', '');
        }
        
        // Get shipping address
        $ship = Shipping::where(['user_id' => auth()->user()->id])->latest()->first();
        if (!$ship) {
            \Log::error('No shipping address found for user: ' . auth()->user()->id);
            Session()->flash('alert', 'danger');
            Session()->flash('message', 'Shipping address not found');
            return redirect()->route('checkout.index');
        }
        
        \Log::info('Shipping address found with ID: ' . $ship->id);
        
        try {
            DB::beginTransaction();
            \Log::info('Database transaction started');
            
            $order = new Order;
            $order->user_id = auth()->user()->id;
            $order->order_No = $order_list->order_No;
            $order->payment_ref = $transactions->payment_ref;
            $order->payment_method = 'Card Payment';
            $order->amount = $transactions->amount;
            $order->is_paid = 0;
            $order->is_delivered = 0;
            $order->shipping_id = $ship->id;
            
            \Log::info('Attempting to save order with data:', [
                'user_id' => $order->user_id,
                'order_No' => $order->order_No,
                'payment_ref' => $order->payment_ref,
                'amount' => $order->amount,
                'shipping_id' => $order->shipping_id
            ]);
            
            if ($order->save()) {
                \Log::info('Order saved successfully with ID: ' . $order->id);
                
                // UPDATE THE CREDIT TRANSACTION WITH ORDER_NO FIRST
                $creditUpdate = Transaction::where('user_id', auth()->user()->id)
                    ->where('payment_ref', $transactions->payment_ref)
                    ->update(['order_No' => $order_list->order_No]);
                
                \Log::info('Credit transaction updated: ' . $creditUpdate . ' rows affected');
                
                # ===============Charge User ========================
                \Log::info('Calling chargeUser method');
                $chargeResult = $this->chargeUser($transactions->amount, $transactions->external_ref, $order_list->order_No, $transactions->payment_ref);
                
                if ($chargeResult) {
                    \Log::info('chargeUser completed successfully');
                } else {
                    \Log::error('chargeUser returned false');
                    throw new \Exception('Charge user failed');
                }
                
                // CLEAR THE CART - Multiple methods for safety
                \Log::info('Clearing cart...');
                
                // Method 1: Clear the entire cart
                \Cart::clear();
                \Log::info('Cart cleared using clear() method');
                
                // Method 2: Destroy the cart (alternative method)
                \Cart::session(auth()->user()->id)->clear();
                \Log::info('Cart cleared using session clear() method');
                
                // Method 3: Verify cart is empty
                $cartAfterClear = \Cart::getContent();
                $cartCountAfterClear = count($cartAfterClear);
                \Log::info('Cart count after clearing: ' . $cartCountAfterClear . ' items');
                
                if ($cartCountAfterClear > 0) {
                    \Log::warning('Cart still has items after clearing, using destroy method');
                    \Cart::destroy();
                    \Log::info('Cart destroyed using destroy() method');
                }
                
                // Final verification
                $finalCartCount = count(\Cart::getContent());
                \Log::info('Final cart count: ' . $finalCartCount . ' items');
                
                // Refresh the order data after chargeUser
                $order->refresh();
                \Log::info('Order refreshed, is_paid: ' . $order->is_paid);
                
                $order->is_paid = 1;
                $order->save();
                \Log::info('Order marked as paid');
                
                $order_items = OrderItem::where(['user_id' => auth()->user()->id, 'order_No' => $order_list->order_No])->get();
                if ($order_items->isEmpty()) {
                    \Log::error('No order items found after payment for order: ' . $order_list->order_No);
                    throw new \Exception('No order items found after payment');
                }
                
                \Log::info('Found ' . $order_items->count() . ' order items');
                
                // Get the updated shipping with order number
                $shipping = Shipping::where('order_No', $order_list->order_No)->first();
                if (!$shipping) {
                    \Log::warning('Shipping not found with order_No, using latest shipping');
                    // Fallback to latest shipping if order_No not set yet
                    $shipping = Shipping::where('user_id', auth()->user()->id)->latest()->first();
                }
                
                \Log::info('Shipping retrieved: ' . ($shipping ? 'Found' : 'Not found'));
                
                DB::commit();
                \Log::info('Database transaction committed');
                
                // SUCCESS - Navigate to success page
                Session()->flash('message', 'Thank you!, Payment Completed and Your order has been received');
                
                $title = 'New Order Received';
                $message = 'You order is received, thanks for choosing us.';
                $this->sendNotify($title, $message);
                
                $title = 'New Payment Received';
                $message = 'You Payment is received successfully, thanks for choosing us.';
                $this->sendNotify($title, $message);
                
                #============================ SEND PAYMENT RECEIVED MAIL ======================
                $data = [
                    'order_No' => $order->order_No,
                    'payment_ref' => $transactions->payment_ref,
                    'external_ref' => $transactions->external_ref,
                    'amount' => $transactions->amount,
                    'email' => auth()->user()->email,
                ];
                
                $this->sendMail($data);
                
                #===================== Send order Mail =========================
                $order_mail = OrderItem::where('order_No', $order->order_No)->get();
                
                $datas = [
                    'order_No' => $order->order_No,
                    'name' => auth()->user()->name,
                    'amount' => $transactions->amount,
                    'email' => auth()->user()->email,
                    'receiver_name' => $shipping->receiver_name,
                    'phone' => $shipping->receiver_phone,
                    'address' => $shipping->address,
                    'delivery_method' => $shipping->delivery_method,
                    'order_items' => $order_mail,
                ];
                
                $this->OrderMail($datas);
                
                // SUCCESS: Navigate to completed page with all data
                $debitTransaction = Transaction::where(['order_No' => $order->order_No, 'type' => 'debit'])->latest()->first();
                
                \Log::info('=== SUCCESS storeOrder - Navigating to completed page ===');
                \Log::info('Cart has been successfully cleared');
                
                return view('users.products.completed')
                    ->with('order', $order)
                    ->with('shipping', $shipping)
                    ->with('order_items', $order_mail)
                    ->with('transaction', $debitTransaction)
                    ->with('title', 'Payment Completed');
                    
            } else {
                \Log::error('Order save() returned false');
                DB::rollBack();
                Session()->flash('alert', 'danger');
                Session()->flash('message', 'Failed to save order');
                return redirect()->back();
            }
            
        } catch (\Exception $e) {
            \Log::error('Exception in storeOrder: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            DB::rollBack();
            Session()->flash('alert', 'danger');
            Session()->flash('message', 'Order processing failed: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function chargeUser($amount, $external_ref, $order_No, $transaction_ref)
    {
        \Log::info('=== START chargeUser ===');
        \Log::info('Parameters - amount: ' . $amount . ', order_No: ' . $order_No . ', transaction_ref: ' . $transaction_ref);
        
        $user = User::where(['id' => auth()->user()->id])->first();
        
        // Check if user exists
        if (!$user) {
            \Log::error('User not found during charge operation for user ID: ' . auth()->user()->id);
            throw new \Exception('User not found during payment processing');
        }
        
        \Log::info('User found: ' . $user->id . ', wallet: ' . $user->wallet);
        
        // Ensure user has sufficient wallet balance
        if ($user->wallet < $amount) {
            \Log::error('Insufficient wallet balance for user: ' . $user->id . '. Required: ' . $amount . ', Available: ' . $user->wallet);
            throw new \Exception('Insufficient wallet balance');
        }
        
        $new_wallet = $user->wallet - $amount;
        \Log::info('New wallet balance will be: ' . $new_wallet);
        
        try {
            DB::beginTransaction();
            \Log::info('chargeUser: Database transaction started');
            
            // Update user wallet
            $updateResult = User::where('id', $user->id)->update(['wallet' => $new_wallet]);
            
            if (!$updateResult) {
                \Log::error('Failed to update wallet for user: ' . $user->id);
                throw new \Exception('Failed to update wallet');
            }
            
            \Log::info('User wallet updated successfully');
            
            // Create transaction record
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'payment_ref' => $transaction_ref,
                'external_ref' => $external_ref,
                'payment_method' => 'Wallet',
                'order_No' => $order_No,
                'type' => 'debit',
                'amount' => $amount,
                'prev_balance' => $user->wallet,
                'avail_balance' => $new_wallet
            ]);
            
            if (!$transaction) {
                \Log::error('Failed to create transaction record for user: ' . $user->id);
                throw new \Exception('Failed to create transaction record');
            }
            
            \Log::info('Debit transaction created with ID: ' . $transaction->id);
            
            // Update order status - ensure this works
            $orderUpdate = Order::where('order_No', $order_No)->update([
                'is_paid' => 1,
                'payment_ref' => $transaction_ref
            ]);
            
            if ($orderUpdate === 0) {
                \Log::warning('Order status update affected 0 records for order: ' . $order_No);
                // Check if order exists
                $orderExists = Order::where('order_No', $order_No)->exists();
                if (!$orderExists) {
                    \Log::error('Order not found with order_No: ' . $order_No);
                    throw new \Exception('Order not found with order_No: ' . $order_No);
                } else {
                    \Log::info('Order exists but update affected 0 rows - might already be paid');
                }
            } else {
                \Log::info('Order status updated to paid for order: ' . $order_No);
            }
            
            // Update ALL related transactions with order_No
            $transactionsUpdated = Transaction::where('user_id', $user->id)
                ->where(function($query) use ($transaction_ref, $external_ref) {
                    $query->where('payment_ref', $transaction_ref)
                        ->orWhere('external_ref', $external_ref)
                        ->orWhereNull('order_No');
                })
                ->update(['order_No' => $order_No]);
            
            \Log::info('Updated ' . $transactionsUpdated . ' transactions with order_No: ' . $order_No);
            
            // Update shipping with order number
            $shippingUpdate = Shipping::where('user_id', $user->id)
                ->whereNull('order_No')
                ->update(['order_No' => $order_No]);
            
            \Log::info('Updated ' . $shippingUpdate . ' shipping records with order_No: ' . $order_No);
            
            DB::commit();
            \Log::info('chargeUser: Database transaction committed');
            
            \Log::info('Successfully charged user: ' . $user->id . ' amount: ' . $amount . ' for order: ' . $order_No);
            
            \Log::info('=== END chargeUser - SUCCESS ===');
            return true;
            
        } catch (\Exception $e) {
            \Log::error('Exception in chargeUser: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            DB::rollBack();
            \Log::error('Charge user failed: ' . $e->getMessage() . ' for user: ' . $user->id);
            throw new \Exception('Payment processing failed: ' . $e->getMessage());
        }
    }

    public function test(){
        $order = Order::latest()->first();
        Session()->flash('message', 'Thank you!, Your order has been received');
        return view('users.products.completed')
        ->with('order',$order )
        ->with('shipping', Shipping::where('order_No', $order->order_No)->latest()->first())
        ->with('order_items', OrderItem::where('order_No',$order->order_No)->latest()->get())
        ->with('transaction', Transaction::where(['order_No' => $order->order_No, 'type' => 'debit'])->first());
    }

    public function sendNotify($title, $message){
        $getUser = User::where('id', auth()->user()->id)->first();
        $notify = new Notification;
        $notify->user_id = $getUser->id;
        $notify->title = $title;
        $notify->message = 'Dear '.$getUser->name. ', <br>'.$message;
        $notify->save();
        $admin = new AdminNotify;
        $admin->message = $title;
        $admin->save();

    }
}
