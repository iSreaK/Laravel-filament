<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::with('addresses')->get();

        foreach ($users as $user) {
            $defaultAddress = $user->addresses->first();
            
            if ($defaultAddress) {
                Order::create([
                    'user_id' => $user->id,
                    'address_id' => $defaultAddress->id,
                    'payment_method' => 'card',
                    'status' => 'completed',
                    'total' => 99.99
                ]);
            }
        }
    }
}
