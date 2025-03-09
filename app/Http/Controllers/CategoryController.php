<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Categories/Index', [
            'categories' => Category::all()
        ]);
    }

    public function products(Request $request, $categoryId = null): Response
    {
        $query = Product::with(['coverImage', 'categories']);

        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        $selectedCategory = $categoryId ? Category::find($categoryId) : null;

        return Inertia::render('Products/Index', [
            'products' => $query->get(),
            'categories' => Category::all(),
            'selectedCategory' => $selectedCategory ? [
                'id' => $selectedCategory->id,
                'name' => $selectedCategory->name
            ] : null
        ]);
    }
} 