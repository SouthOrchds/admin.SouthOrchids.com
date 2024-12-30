<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Cart::class;

    public function definition(): array
    {
        return [
            "user_id"=> User::inRandomOrder()->first()->id,
            "product_id"=> Product::inRandomOrder()->first()->id,
            "quantity"=> $this->faker->numberBetween(1,5),
            "remember_token"=> $this->faker->optional()->word,
        ];
    }
}
