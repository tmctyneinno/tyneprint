<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\pricequotation;
use Illuminate\Support\Facades\Mail;
use App\Mail\Sendquotation;
use App\Models\PrintRequest;
use App\Http\Requests\Pricequote;

class PricequoteController extends Controller
{
    use pricequotation;

    public function getRequest(Pricequote $request){
     $data = $this->StoreQuotes($request); 
    PrintRequest::create($data);
  //  Mail::to($request->email)->send(new Sendquotation($request));
    return back();
    }
    
}
