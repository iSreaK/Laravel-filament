<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ImageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->first()?->id,
            'image' => $this->faker->imageUrl(640, 480, 'products'),
            'alt_text' => $this->faker->sentence(),
            'cover_image' => $this->faker->boolean(20), // 20% de chance d’être une image de couverture
        ];
    }
}
