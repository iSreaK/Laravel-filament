<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartAddController extends Controller
{
    public function __invoke(Request $request, $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            $cart[$id] = [
                "id" => $product->id,
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);
        
        return redirect()->route('cart.show')->with('success', 'Produit ajouté au panier');
    }
}
