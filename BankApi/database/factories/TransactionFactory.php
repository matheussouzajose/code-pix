<?php

namespace Database\Factories;

use App\Models\BankAccount;
use App\Models\PixKey;
use Core\Domain\PixKey\Enum\PixKeyKind;
use Core\Domain\Shared\ObjectValues\Uuid;
use Core\Domain\Transaction\Enum\TransactionOperation;
use Core\Domain\Transaction\Enum\TransactionStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BankAccount>
 */
class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => Uuid::random(),
            'external_id' => Uuid::random(),
            'bank_account_from_id' => Uuid::random(),
            'pix_key_kind' => PixKeyKind::email->value,
            'pix_key_key' => fake()->email(),
            'status' => TransactionStatus::Pending,
            'operation' => TransactionOperation::Debit,
            'amount' => 5000,
            'description' => fake()->paragraph(),
            'created_at' => now(),
        ];
    }

    public function toTest(): static
    {
        return $this->state(fn (array $attributes) => [
            'bank_account_from_id' => BankAccount::factory()->create()->id,
            'pix_key_key' => PixKey::factory()->toTest()->create()->key,
        ]);
    }
}
