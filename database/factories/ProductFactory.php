<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $capitalPrice = fake()->numberBetween(1000, 100000);
        return [
            'name' => fake()->sentence(2),
            'image' => '01HHM8Q6K4RKXVQRVTNCYQD5SQ.png',
            'capital_price' => $capitalPrice,
            'sell_price' => $capitalPrice + 1000,
            'stock' => fake()->numberBetween(1, 20),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
