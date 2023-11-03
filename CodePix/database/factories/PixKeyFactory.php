<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\PixKey;
use Core\Domain\PixKey\Enum\KindType;
use Core\Domain\PixKey\Enum\StatusType;
use Core\Domain\Shared\ObjectValues\Uuid;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PixKey>
 */
class PixKeyFactory extends Factory
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
            'kind' => KindType::Email->value,
            'key' => fake()->email(),
            'status' => StatusType::Active->value,
            'created_at' => now()
        ];
    }

    public function toTest(): static
    {
        return $this->state(fn (array $attributes) => [
            'account_id' => Account::factory()->toTest()->create()->id
        ]);
    }
}
