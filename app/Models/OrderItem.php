<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [

        'user_id',
        'order_No',
        'product_id',
        'price',
        'qty',
        'payable',
        'image',
        'design_image',
        'design_type',
        'description'


    ];


    public function user(){

        return $this->belongsTo(User::class);
    }

 
}
