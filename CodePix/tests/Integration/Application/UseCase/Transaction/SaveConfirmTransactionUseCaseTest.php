<?php

namespace Tests\Integration\Application\UseCase\Transaction;

use App\Models\Transaction as TransactionModel;
use Core\Application\UseCase\Transaction\Status\SaveConfirmTransactionUseCase;
use Core\Application\UseCase\Transaction\Status\SaveTransactionInputDto;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Transaction\Enum\StatusTransactionType;
use Core\Infrastructure\Exceptions\NotFoundException;
use Core\Ui\Factories\Repository\TransactionRepositoryFactory;
use Tests\TestCase;

class SaveConfirmTransactionUseCaseTest extends TestCase
{
    /**
     * @throws NotificationException
     */
    public function test_save_complete_error()
    {
        $this->expectExceptionObject(NotFoundException::itemNotFound(''));

        $transaction = new SaveConfirmTransactionUseCase(
            transactionRepository: TransactionRepositoryFactory::create()
        );

        $input = new SaveTransactionInputDto(
            id: ''
        );

        ($transaction)($input);
    }

    /**
     * @throws NotificationException
     */
    public function test_save_complete_transaction()
    {

        $transaction = new SaveConfirmTransactionUseCase(
            transactionRepository: TransactionRepositoryFactory::create()
        );

        $input = new SaveTransactionInputDto(
            id: TransactionModel::factory()->toTest()->create()->id
        );

        ($transaction)($input);

        $this->assertDatabaseCount('transactions', 1);
        $this->assertDatabaseHas('transactions', [
            'status' =>  StatusTransactionType::Confirmed->value,
        ]);
    }
}
