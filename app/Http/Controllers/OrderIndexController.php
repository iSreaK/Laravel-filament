<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Inertia\Inertia;
use Inertia\Response;

class OrderIndexController extends Controller
{
    public function __invoke(): Response
    {
        $orders = Order::where('user_id', auth()->id())->get();
        return Inertia::render('Orders/Index', [
            'orders' => $orders
        ]);
    }
}
