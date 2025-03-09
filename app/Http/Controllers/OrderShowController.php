<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Inertia\Inertia;
use Inertia\Response;

class OrderShowController extends Controller
{
    public function __invoke($id): Response
    {
        $order = Order::with('items')->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        
        return Inertia::render('Orders/Show', [
            'order' => $order
        ]);
    }
}
