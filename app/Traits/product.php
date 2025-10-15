<?php

namespace App\Traits\Product;

trait Product
{
    /**
     * Prepare product data for storage.
     */
    protected function productStore($request): array
    {
        return [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'image' => $request->image,
            'gallery' => $request->gallery,
            'description' => $request->description,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'percentage' => $request->percentage,
        ];
    }
}
