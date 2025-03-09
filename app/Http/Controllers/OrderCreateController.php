<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class OrderCreateController extends Controller
{
    public function __invoke(): Response
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'Votre panier est vide');
        }

        return Inertia::render('Orders/Create', [
            'addresses' => auth()->user()->addresses,
            'defaultAddress' => auth()->user()->defaultAddress
        ]);
    }
}
