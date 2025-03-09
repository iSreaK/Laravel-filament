<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Discount;
use App\Models\Image;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Item;
use App\Models\User;
use App\Models\Address;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            ImageSeeder::class,
            AddressSeeder::class,
            OrderSeeder::class,
        ]);

        Discount::factory(5)->create();
        Category::factory(5)->create();
        
        Product::factory(20)->create()->each(function ($product) {
            $product->categories()->attach(rand(1, 5));
        });

        Cart::factory(10)->create();
        CartItem::factory(30)->create();

        // Modification de la création des commandes
        User::with('addresses')->get()->each(function ($user) {
            $defaultAddress = $user->addresses->first();
            if ($defaultAddress) {
                $orders = Order::factory(2)->create([
                    'user_id' => $user->id,
                    'address_id' => $defaultAddress->id,
                    'payment_method' => 'card'
                ]);

                Item::factory(5)->create()->each(function ($item) use ($orders) {
                    $item->order_id = $orders->random()->id;
                    $item->save();
                });
            }
        });
    }
}
