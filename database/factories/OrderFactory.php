<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        // Fetch random products or create if none exist
        $products = Product::inRandomOrder()->take($this->faker->numberBetween(1, 9))->get();
        if ($products->isEmpty()) {
            $products = Product::factory(10)->create();
        }

        // Map order items
        $orderItems = $products->map(function ($product) {
            $quantity = $this->faker->numberBetween(1, 5);
            return [
                "product_id" => $product->id,
                "price" => $product->price,
                "quantity" => $quantity,
                "total" => $product->price * $quantity,
            ];
        })->toArray();

        // Calculate total amount
        $totalAmount = collect($orderItems)->sum("total");

        return [
            "user_id" => User::inRandomOrder()->first()?->id ?? User::factory()->create()->id, // Ensure a user exists
            "orders" => json_encode(["items" => $orderItems]),
            "order_date" => $this->faker->dateTimeBetween('-3 weeks', 'now'),
            "total_amount" => $totalAmount,
            "status" => $this->faker->randomElement(['Placed', 'Accepted', 'Shipped', 'Delivered']),
        ];
    }
}
