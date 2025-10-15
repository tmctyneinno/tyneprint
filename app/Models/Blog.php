<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    //

    protected $fillable = [
        'title', 'content', 'views', 'image', 'gallery', 'status', 'added_by'

    ];
}
