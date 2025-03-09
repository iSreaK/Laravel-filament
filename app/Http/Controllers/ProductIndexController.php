<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Models\Category;
use Inertia\Inertia;
use Inertia\Response;

class ProductIndexController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function __invoke(): Response
    {
        return Inertia::render('Products/Index', [
            'products' => $this->productService->getProductsWithDetails(),
            'categories' => Category::all()
        ]);
    }
}

