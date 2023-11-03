<?php

namespace Database\Factories;

use App\Models\BankAccount;
use Core\Domain\Shared\ObjectValues\Uuid;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BankAccount>
 */
class BankAccountFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => Uuid::random(),
            'number' => (string) fake()->unique()->randomNumber(3),
            'owner_name' => fake()->name(),
            'balance' => 10000,
            'created_at' => now(),
        ];
    }
}
