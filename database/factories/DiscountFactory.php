<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DiscountFactory extends Factory
{
    public function definition(): array
    {
        return [
            'number' => $this->faker->numberBetween(5, 50), // Remise entre 5% et 50%
            'expiration_date' => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}

