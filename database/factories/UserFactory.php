<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\User::class;

    public function definition(): array
    {
        return [
            "name"=> $this->faker->name,
            "email"=> $this->faker->unique()->safeEmail,
            "phone_no"=> $this->faker->unique()->numerify("##########"),
            "apiToken"=> Str::random(50),
            "password"=> bcrypt('password'),
            "city"=> $this->faker->city,
            "address"=> $this->faker->address,
            "pincode"=> $this->faker->postcode,
        ];
    }
}
