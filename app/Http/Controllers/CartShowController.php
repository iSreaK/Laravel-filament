<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class CartShowController extends Controller
{
    public function __invoke(): Response
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $id => $item) {
            $cartItems[] = [
                'id' => $id,
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity']
            ];
            $total += $item['price'] * $item['quantity'];
        }

        return Inertia::render('Cart/Show', [
            'cart' => $cartItems,
            'total' => $total
        ]);
    }
}
