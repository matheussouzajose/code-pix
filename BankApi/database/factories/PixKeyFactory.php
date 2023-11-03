<?php

namespace Database\Factories;

use App\Models\BankAccount;
use Core\Domain\PixKey\Enum\PixKeyKind;
use Core\Domain\Shared\ObjectValues\Uuid;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BankAccount>
 */
class PixKeyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => Uuid::random(),
            'bank_account_id' => Uuid::random(),
            'kind' => PixKeyKind::email->value,
            'key' => fake()->email(),
            'created_at' => now(),
        ];
    }

    public function toTest(): static
    {
        return $this->state(fn (array $attributes) => [
            'bank_account_id' => BankAccount::factory()->create()->id,
        ]);
    }
}
