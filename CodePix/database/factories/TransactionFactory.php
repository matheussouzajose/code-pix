<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\PixKey;
use Core\Domain\Shared\ObjectValues\Uuid;
use Core\Domain\Transaction\Enum\StatusTransactionType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PixKey>
 */
class TransactionFactory extends Factory
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
            'account_id' => Uuid::random(),
            'pix_key_id' => Uuid::random(),
            'amount' => fake()->randomNumber(3),
            'description' => fake()->word(),
            'status' => StatusTransactionType::Pending->value,
            'created_at' => now()
        ];
    }

    public function toTest(): static
    {
        return $this->state(fn (array $attributes) => [
            'account_id' => Account::factory()->toTest()->create()->id,
            'pix_key_id' => PixKey::factory()->toTest()->create()->id
        ]);
    }
}
