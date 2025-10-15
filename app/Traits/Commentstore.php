<?php 
namespace App\Traits;

trait Commentstore
{


    public function CommentStore($request, $id)
    {
        $data = [ 
            'blog_id' => $id,
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ];
        return $data;

    }

}




