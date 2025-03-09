<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Inertia\Response;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Products/Index', [
            'products' => Product::with(['coverImage', 'categories'])->get(),
            'categories' => Category::all(),
            'selectedCategory' => null
        ]);
    }

    public function show($id): Response
    {
        $product = Product::with(['coverImage', 'categories'])->findOrFail($id);
        return Inertia::render('Products/Show', [
            'product' => $product
        ]);
    }
} 