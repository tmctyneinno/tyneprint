<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'image',
        'gallery',
        'description',
        'price' ,
        'sale_price',
        'percentage',
        'design_fee'
    ];

    
    public function category(){

        return $this->belongsTo(Category::class);
    }
      
    public function PriceList(){
        return $this->hasMany(ProductVariation::class);
    }

   
    public function metas(){
        return $this->hasMany(PrintMeta::class);
       }
}
