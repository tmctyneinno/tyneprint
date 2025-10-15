<?php

namespace App\Traits;

trait CheckoutStore
{
/**

*@param $request 
*@return mixed  
*/

    private function CreateUser($request){
        return $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password'=> $request->pass,
        ];

    }

    private function OrderItems($request){
        $data = [
            'user_id' => auth()->user()->id,
            'order_id' => $request->order_id,
            'product_id' => $request->product_id,
            'price' => $request->price,
            'payable' => $request->payable,
            'qty' => $request->qty
        ];

        return $data;

    }

    private function StoreShippingAddress($request)
    {

        $data = [
            'user_id'=> auth()->user()->id,
            'receiver_name' => $request->receiver_name,
            'receiver_email' => $request->receiver_email,
            'receiver_phone' => $request->receiver_phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' =>$request->zip_code,
            'delivery_method'=>$request->delivery_method,
        ];
        return $data;
    }












}