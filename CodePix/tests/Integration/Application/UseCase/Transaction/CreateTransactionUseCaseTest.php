<?php

namespace Tests\Integration\Application\UseCase\Transaction;

use App\Models\Account as AccountModel;
use App\Models\PixKey as PixKeyModel;
use Core\Application\UseCase\Transaction\Create\CreateTransactionInputDto;
use Core\Application\UseCase\Transaction\Create\CreateTransactionUseCase;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;
use Core\Ui\Factories\Repository\PixKeyRepositoryFactory;
use Core\Ui\Factories\Repository\TransactionRepositoryFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTransactionUseCaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws NotificationException
     */
    public function test_create_transaction()
    {
        $transaction = new CreateTransactionUseCase(
            transactionRepository: TransactionRepositoryFactory::create(),
            pixKeyRepository: PixKeyRepositoryFactory::create()
        );

        $account = AccountModel::factory()->toTest()->create();
        $pixKeyTo = PixKeyModel::factory()->toTest()->create();

        $input = new CreateTransactionInputDto(
            externalId: Uuid::random(),
            accountId: $account->id,
            amount: 100.00,
            pixKeyTo: $pixKeyTo->key,
            pixKeyKindTo: 'email',
            description: 'Description'
        );

        $result = ($transaction)($input);

        $this->assertDatabaseCount('transactions', 1);
        $this->assertDatabaseHas('transactions', [
            'id' =>  $result->id,
            'account_id' =>  $result->accountId,
            'pix_key_id' =>  $result->pixKeyId,
            'status' =>  $result->status,
            'created_at' =>  $result->createdAt,
        ]);
    }
}
