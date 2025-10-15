<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\PostComment;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function readMore($id){
        return view('users.pages.blogDetails', [
           'blogs' =>  Blog::where('id', decrypt($id))->first(),
           'post' => PostComment::where('blog_id', decrypt($id))->get()
        ]);
    }
}
