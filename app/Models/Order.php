<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [

        'user_id',
        'order_No',
        'external_ref',
        'payment_ref',
        'payment_method',
        'amount',
        'shipping_id',
        'is_delivered',
        'is_paid',
        'dispatch_status'
    ];

    public function shipping(){
        return $this->belongsTo(Shipping::class, 'shipping_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
