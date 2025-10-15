<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Menu;
use App\Models\PostComment;

class PagesController extends Controller
{
    
    public function Pages($id){
        $id = decrypt($id);
        $menu = Menu::where('id', $id)->first();
        $menus = preg_replace("/\s+/", "",$menu->name);
        $product = Product::where('id', 19)->first();
        if($menus == 'Blogs'){
            return view('users.pages'.".".$menus, [
                'blogs' => Blog::take('16')->latest()->get(), 
            ]);
        }
        return view('users.pages'.".".$menus, compact('product'));
    }
}
