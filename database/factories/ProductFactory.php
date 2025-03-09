<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 10, 100),
            'stock' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->paragraph,
            'discount_id' => Discount::inRandomOrder()->first()?->id, // Nullable
        ];
    }

    public function afterCreating($product)
    {
        // Ajouter des catégories au produit après sa création
        $categories = Category::inRandomOrder()->take(3)->pluck('id');
        $product->categories()->attach($categories); // Attacher ces catégories au produit
    }
}
