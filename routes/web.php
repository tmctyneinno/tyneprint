<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PricequoteController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PostCommentController;

 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Laravel built-in authentication routes
Auth::routes(); 
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/products/details/{id}', [HomeController::class, 'productDetails'])->name('product-details');

Route::post('/cart/{id}', [CartController::class, 'add'])->name('cart.add');
// Change {id} to {rowId} to match your form
Route::delete('cart/{rowId}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::resource('/carts', CartController::class);

Route::resource('/products', ProductController::class);
Route::resource('/checkout', CheckoutController::class);

Route::get('/payment/{trxref}', [CheckoutController::class, 'verify'])->name('verify.pay');
Route::post('/checkout/store-order', [CheckoutController::class, 'storeOrder'])->name('checkout.storeOrder');
Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');

Route::get('/address/checkout', [CheckoutController::class, 'addNew'])->name('checkout.addNew');
Route::post('/checkouts', [CheckoutController::class, 'Add']);
Route::post('/verify-payment', [CheckoutController::class, 'verifyPayment'])->name('verify.payment');
Route::post('/checkout/update-order-status', [CheckoutController::class, 'updateOrderStatus'])->name('checkout.updateOrderStatus');

Route::get('/order/success', [CheckoutController::class, 'orderSuccess'])->name('order.success');
 Route::get('/orders/{order}', [CheckoutController::class, 'show'])->name('orders.show');
 Route::get('/order/completed/{order_id?}', [CheckoutController::class, 'completed'])->name('order.completed');

Route::get('/howitworks', [HomeController::class, 'Pages'])->name('Howitworks');
Route::get('/pages/{id}', [PagesController::class, 'Pages'])->name('pages');
Route::get('/user/search', [SearchController::class, '__invoke'])->name('search');
Route::post('/price/quotation', [PricequoteController::class, 'getRequest'])->name('price.quote');
Route::get('blogs/details/{id}', [BlogController::class, 'readMore'])->name('blog.readMore');
Route::post('/post/comments/{id}', [PostCommentController::class, '__invoke'])->name('post.comments');

Route::get('/category/{id}', [HomeController::class, 'Categories'])->name('user.category');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('user/dashboard', [HomeController::class, 'AccountIndex'])->name('user.index');
    Route::get('user/myaccount', [HomeController::class, 'myAccount'])->name('user.account');
    Route::get('user/orders', [HomeController::class, 'myOrders'])->name('user.orders');
    Route::get('user/transactions', [HomeController::class, 'myTransactions'])->name('user.transactions');
    Route::get('/users/order/details/{id}', [HomeController::class, 'OrderDetails'])->name('user.order-details');
    Route::post('/users/account/details', [HomeController::class, 'updateDetails'])->name('update.user-details');
    Route::get('/user/notify', [HomeController::class, 'notifications'])->name('user.notification');
    Route::get('/user/notify/delete/{id}', [HomeController::class, 'notificationDel'])->name('notify.delete');
});


 
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
