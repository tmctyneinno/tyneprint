<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'deliveries';
    protected $fillable = [
        'delivery_id',
        'user_id',
        'shipping_id',
        'delivery_fee',
        'distance' ,
        'time' ,
        'status',
    ];
}