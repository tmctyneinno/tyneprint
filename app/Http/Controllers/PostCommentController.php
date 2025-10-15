<?php

namespace App\Http\Controllers;
use App\Http\Requests\PostComments;
use App\Models\PostComment;
use Illuminate\Http\Request;
use App\Traits\Commentstore;
use App\Models\Blog;

class PostCommentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     use Commentstore;

    public function __invoke(PostComments $request, $id)
    {
        $data = $this->CommentStore($request, decrypt($id));
        PostComment::create($data);
        return redirect()->back();
    }
}
