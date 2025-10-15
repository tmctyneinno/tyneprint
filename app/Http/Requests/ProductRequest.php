<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'category_id' => 'required|integer',
            'image' => 'required',
            'gallery' => 'required',
            'description' => 'required',
            'price' => 'required',
            'sale_price' => 'required',
            'design_fee' => 'required',
            'amount' => 'required',
            'qty' => 'required'
        ];
    }
}
