<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use Illuminate\Support\Carbon;
use App\Models\Notification;
use App\Models\User;
use App\Models\Menu;
use App\Models\Shipping; 
use App\Traits\decryptId;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    use decryptId;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('users.home', [
            'products' => Product::with('PriceList')->take(28)->get(),
        ])->with('title', 'Designs, Print flyers, business cards');
        
    }

    public function productDetails($id){
        $id = $this->decryptId($id);
        $product = Product::where('id', $id)->first();
                Product::where('id', $id)
                ->update(['views' => $product->views + 1]);
        return view('users.products.products',[
                'product' => $product,
                'category' => $product->category->name
            ]) ->with('title', $product->name)
                ->with('breadcrumb', $product->name);
               
        }

        public function AccountIndex(){
          return view('users.accounts.index', [
            'orders' => count(Order::where('user_id', auth()->user()->id)->get()),
            'order' => Order::where('user_id', auth()->user()->id)->first(),
            'user' => User::where('id', auth()->user()->id)->first(),
            'address' => Shipping::where('user_id', auth()->user()->id)->first(),
            'pending' => count(Order::where(['user_id'=> auth()->user()->id, 'is_delivered'=> 0])->get()),
            'completed' => count(Order::where(['user_id'=> auth()->user()->id, 'is_delivered'=> 1])->get())
          ]);
                   
        }


        public function myAccount(){
            return view('users.accounts.profile', [
                'orders' => Order::where('user_id', auth()->user()->id)->latest()->get(),
                'transactions' => Transaction::where('user_id', auth()->user()->id)->simplePaginate(5),
                'user' => User::where('id', auth()->user()->id)->first()
            ]);
                    
        }

        public function myOrders(){
            return view('users.accounts.orders')
            ->with('orders', Order::where('user_id', auth()->user()->id)->latest()->simplePaginate(10))
            ->with('user', User::where('id', auth()->user()->id)->first());

        }

        
        public function myTransactions(){
            return view('users.accounts.transactions')
            ->with('transactions', Transaction::where(['user_id' =>auth()->user()->id,'type' => 'debit'])->latest()->simplePaginate(10))
            ->with('user', User::where('id', auth()->user()->id)->first());

        }

public function OrderDetails($id){
            $order = Order::where('order_No', $id)->first();
            return view('users.accounts.orderDetails')
            ->with('order',$order )
            ->with('shipping', Shipping::where('order_No', $order->order_No)->latest()->first())
            ->with('order_items', OrderItem::where('order_No',$order->order_No)->latest()->get())
            ->with('transaction', Transaction::where(['order_No' => $order->order_No, 'type' => 'debit'])->latest()->first());
        }

public function notifications(){
            $notify = Notification::where('user_id', auth()->user()->id)->latest()->simplePaginate(7);
            return view('users.accounts.notify', compact('notify'));
        }
public function notificationDel($id){
            $del = Notification::where('id', decrypt($id))->first();
            $del->delete();
            return redirect()->back();
        }

 public function updateDetails(Request $request){

   // dd($request->all());
            if($request->name){
             $update_user = [
                 'name' => $request->name,
             ];
    
             DB::table('users')
              ->where('id', auth()->user()->id)
               ->update($update_user);
    
               if(!isset($request->password)){
                Session()->flash('message', 'Details Updated Successfully');
                Session()->flash('alert', 'success');
               return redirect()->back()->with('success', 'Details Updated Successfully');
            }
        }
    
            if($request->password){
             $this->validate($request, [
            'oldPassword' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation'=>'required'
            ]);
     
           $hashedPassword = auth()->user()->password;
            
            if (\Hash::check($request->oldPassword , $hashedPassword)) {
            if (!\Hash::check($request->password , $hashedPassword)) {
                  $users =user::find(Auth()->user()->id);
                  $users->password = bcrypt($request->password);
                  user::where( 'id' , auth()->user()->id)->update( array( 'password' =>  $users->password));
                  Session()->flash('message', 'Details/Pass Updated Successfully');
                  Session()->flash('alert', 'success');
                  return redirect()->back()->with('success', 'Details/Pass Updated Successfully');
                }
                else{
                    Session()->flash('message', 'Old Password / New Password Cannot be the Same');
                    Session()->flash('alert', 'danger');
                    return redirect()->back()->with('error', 'Old Password / New Password Cannot be the Same');}
            } else{
                Session()->flash('message', 'Old Password is Incorrect');
                Session()->flash('alert', 'danger');
                return redirect()->back()->with('error', 'Old Password is Incorrect');
            }
        }else{
            return back();
        }
    }


    public function Categories($id){
       
        $id = decrypt($id);
        return view('users.shops.category')
            ->with('products',  Product::where('category_id', $id)->where('status', '!=', '1')->simplePaginate(20));
    }
 
   
}
