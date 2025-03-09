<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    /**
     * Le nom du modèle que cette factory fabrique.
     *
     * @var string
     */
    protected $model = Cart::class;

    /**
     * Définir l'état par défaut de la cart.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::exists() ? User::inRandomOrder()->first()->id : User::factory()->create()->id,
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear(),
        ];
    }

    /**
     * L'action après la création du Cart (ex: ajouter des items dans le panier).
     *
     * @return void
     */
    public function afterCreating($cart)
    {
        // Exemple : Ajouter un produit aléatoire dans le panier après sa création
        $products = Product::inRandomOrder()->take(3)->pluck('id');
        
        // Ajout des produits au panier
        $cart->products()->attach($products);
    }
}
