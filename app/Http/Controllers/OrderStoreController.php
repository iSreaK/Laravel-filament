<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderStoreController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function __invoke(Request $request): RedirectResponse
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Le panier est vide.');
        }

        $order = $this->orderService->createOrder($request->all());

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Commande créée avec succès !');
    }
}
