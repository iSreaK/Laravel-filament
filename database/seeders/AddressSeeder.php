<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            Address::create([
                'user_id' => $user->id,
                'street' => 'Rue par défaut',
                'number' => '1',
                'city' => 'Ville par défaut',
                'country' => 'France',
                'postal_code' => '75000',
                'is_default' => true,
                'name' => 'Adresse principale'
            ]);
        }
    }
} 