<?php

namespace App\Providers;

use App\Models\AdminNotify;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Notification;
use App\Models\Product;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Composer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $menu= Menu::all();
        View::share('menu', $menu);
        $categories = Category::All();
        $products = Product::where('status', '!=', '1')->get();
        view::share('product_menu', $products);
        view::share('menu_categories', $categories);
        $unread_notify = AdminNotify::where('is_read', 0)->latest()->take(10)->get();
        $read_notify = AdminNotify::where('is_read', 1)->latest()->take(2)->get();
        view::share('unread_notify', $unread_notify);
        view::share('read_notify', $read_notify);
    }

}
