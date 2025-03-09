<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            // Créer une image de couverture
            Image::create([
                'product_id' => $product->id,
                'image' => 'https://picsum.photos/800/600?random=' . $product->id,
                'alt_text' => $product->name,
                'cover_image' => true
            ]);

            // Créer 2-4 images supplémentaires
            $additionalImages = rand(2, 4);
            for ($i = 0; $i < $additionalImages; $i++) {
                Image::create([
                    'product_id' => $product->id,
                    'image' => 'https://picsum.photos/800/600?random=' . $product->id . $i,
                    'alt_text' => $product->name . ' view ' . ($i + 2),
                    'cover_image' => false
                ]);
            }
        }
    }
}
