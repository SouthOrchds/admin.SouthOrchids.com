<?php

namespace Database\Factories;

use app\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Admin::class;

    public function definition(): array
    {
        return [
            "name"=> $this->faker->name,
            "email"=> $this->faker->unique()->safeEmail,
            "phone_no"=> $this->faker->unique()->numerify("##########"),
            "apiToken"=> Str::random(25),
            "password"=> bcrypt("adminpassword"),
        ];
    }
}
