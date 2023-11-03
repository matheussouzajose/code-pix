<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Bank;
use Core\Domain\Shared\ObjectValues\Uuid;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Account>
 */
class AccountFactory extends Factory
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
            'owner_name' => fake()->name(),
            'number' => fake()->randomNumber(6),
            'bank_id' => Uuid::random(),
            'created_at' => now()
        ];
    }

    public function toTest(): static
    {
        return $this->state(fn (array $attributes) => [
            'bank_id' => Bank::factory()->create()->id
        ]);
    }
}
