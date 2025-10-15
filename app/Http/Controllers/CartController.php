<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariation;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CartController extends Controller
{
    /**
     * Store uploaded images and return filenames.
     */
    protected function storeImage($files)
    {
        $images = [];

        foreach ($files as $image) {
            $name = $image->getClientOriginalName();
            $fileName = time() . '_' . pathinfo($name, PATHINFO_FILENAME) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $fileName);
            $images[] = $fileName;
        }

        return $images;
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail(decrypt($id));

        $images = $request->hasFile('images') 
            ? $this->storeImage($request->file('images')) 
            : [];

        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $request->price,
            'quantity' => $request->qty,
            'attributes' => [
                'images' => $images, 
                'description' => $request->description,
                'design_fee' => $request->design_fee,
                'pricelist' => $product->pricelist
            ],
            'associatedModel' => $product
        ]);

        return redirect()->route('carts.index')
            ->with('message', 'Product added to cart successfully.');
    }

    /**
     * Show cart contents.
     */
    public function index()
    {
        $carts = Cart::getContent();

        return view('users.products.carts', [
            'carts' => $carts,
            'breadcrumb' => 'Shopping Cart',
        ]);
    }

    /**
     * Remove all cart items.
     */
    public function remove()
    {
        Cart::clear();
        return back()->with('message', 'All items removed from cart.');
    }
    

    /**
     * Update an item in the cart.
     */
    public function update(Request $request, $id)
    {
        $variation = ProductVariation::where([
            'product_id' => decrypt($id),
            'qty' => $request->qty,
        ])->first();

        if ($variation) {
            Cart::update($request->rowId, [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->qty
                ],
                'price' => $variation->price,
            ]);

            session()->flash('message', 'Cart updated successfully.');
        } else {
            session()->flash('error', 'Product variation not found.');
        }

        return back();
    }

    /**
     * Remove a specific item from the cart.
     */
    public function destroy($rowId)
    {
        Cart::remove($rowId);
        session()->flash('message', 'Item removed successfully.');
        return back();
    }
}
