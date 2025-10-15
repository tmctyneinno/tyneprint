<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = [
        'user_id',
        'receiver_name',
            'receiver_email',
            'receiver_phone' ,
            'address' ,
            'state',
            'city',
            'zip_code',
            'delivery_method',
            'lng',
            'lat'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
