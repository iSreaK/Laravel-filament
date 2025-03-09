<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;


class ProductShowController extends Controller
{
    public function __invoke($id): Response
    {
        $product = Product::with(['coverImage', 'categories'])->findOrFail($id);
        return Inertia::render('Products/Show', [
            'product' => $product
        ]);
    }
}
