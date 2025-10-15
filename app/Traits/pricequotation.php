<?php 

namespace App\Traits;

use Illuminate\Http\Client\Request;

trait pricequotation{


  
    public function StoreQuotes($request){
       $data = [
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'phone' => $request->phone,
        'message' => $request->message,
        'design' => $request->design,
        'delivery_address' => $request->delivery_address,
   ];

   return $data;

    }




}




