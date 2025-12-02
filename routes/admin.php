<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductFinishingController;

Route::prefix('admin')->group(function () {
  
    // 🔐 Authentication routes
    Route::get('/login', [AdminLoginController::class, 'showLogin'])->name('admin.login');
    Route::get('admin/login', [AdminLoginController::class, 'showLogin'])->name('admin-login');
    

    Route::post('/manage/user/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
    
    // 🔓 Logout route (outside auth middleware)
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

    // 🏠 Admin Dashboard (Protected)
    Route::middleware('auth:admin')->group(function () {

        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/index', [AdminController::class, 'index']); // optional alias

        // 📦 Category & Product Management
        Route::resource('/category', CategoryController::class);
        Route::resource('/product', ProductController::class);

        Route::post('/product/status/{id}', [ProductController::class, 'status'])->name('product.status');
        Route::get('/product/variation/{id}', [ProductController::class, 'variation'])->name('product.variation');
        Route::get('/variation/edit/{id}', [ProductController::class, 'variationEdit'])->name('variation.edit');
        Route::post('/variation/update/{id}', [ProductController::class, 'variationUpdate'])->name('variation.update');

        // 🚚 Orders & Transactions
        Route::get('/orders', [AdminController::class, 'order'])->name('admin.orders');
        Route::get('/orders/details/{id}', [AdminController::class, 'orderDetails'])->name('admin.order-details');

        Route::get('/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
        Route::get('/transaction/details/{id}', [AdminController::class, 'transactionDetails'])->name('admin.transaction-details');

        Route::get('/order/shipping/{id}', [AdminController::class, 'shipping'])->name('admin.shipping');
        Route::get('/order/status/{id}', [AdminController::class, 'status'])->name('order.status');
        Route::post('/status/update/{id}', [AdminController::class, 'updateStatus'])->name('order.status.update');

        // 👥 Users
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/order/{id}', [AdminController::class, 'userOrders'])->name('admin.user-orders');
        Route::get('/users/transaction/{id}', [AdminController::class, 'userTransactions'])->name('admin.user-transactions');

        // 🖼️ Designs
        Route::get('/designs/download/{id}', [AdminController::class, 'getDownloads'])->name('design.download');

        // 🔔 Notifications
        Route::post('/users/notification', [AdminController::class, 'pushNotify'])->name('admin.push-notify');
        Route::get('/users/notify', [AdminController::class, 'notify'])->name('admin.notify');
        Route::get('/notify/{id}', [AdminController::class, 'updateNotify'])->name('update.admin-notify');
        Route::post('/notification/clear', [AdminController::class, 'adminNotifyClear'])->name('admin.notify.clear');

        // 📊 Analytics
        Route::get('/analytics', [AdminController::class, 'analytical'])->name('admin.analytical');

        // 👤 Admin Profile
        Route::get('/profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
        Route::post('/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

        // 🧵 Product Finishing
        Route::get('/add/finishing/variation/{id}', [ProductFinishingController::class, 'addFinishing'])->name('add.finishing');
        Route::post('/store/finishing/{id}', [ProductFinishingController::class, 'store'])->name('store.finishing');
    });
});
