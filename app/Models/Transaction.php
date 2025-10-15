<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    
    protected $fillable = [
        'user_id',
        'amount',
        'payment_ref',
        'external_ref',
        'type',
        'payment_method',
        'order_id',
        'prev_balance',
        'avail_balance'
    ]; 


    public function User(){
        return $this->belongsTo(User::class);
    }
}
