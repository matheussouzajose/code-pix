<?php

namespace Database\Factories;

use App\Models\Bank;
use Core\Domain\Shared\ObjectValues\Uuid;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Bank>
 */
class BankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Uuid::random(),
            'code' => fake()->unique()->randomNumber(3),
            'name' => fake()->unique()->company(),
            'created_at' => now()
        ];
    }
}
