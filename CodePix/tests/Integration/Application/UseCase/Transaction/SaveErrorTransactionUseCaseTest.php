<?php

namespace Tests\Integration\Application\UseCase\Transaction;

use App\Models\Transaction as TransactionModel;
use Core\Application\UseCase\Transaction\Status\SaveErrorTransactionUseCase;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Transaction\Enum\StatusTransactionType;
use Core\Infrastructure\Exceptions\NotFoundException;
use Core\Application\UseCase\Transaction\Status\SaveConfirmTransactionUseCase;
use Core\Application\UseCase\Transaction\Status\SaveTransactionInputDto;
use Core\Ui\Factories\Repository\TransactionRepositoryFactory;
use Tests\TestCase;

class SaveErrorTransactionUseCaseTest extends TestCase
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
    public function test_save_error_transaction()
    {

        $transaction = new SaveErrorTransactionUseCase(
            transactionRepository: TransactionRepositoryFactory::create()
        );

        $input = new SaveTransactionInputDto(
            id: TransactionModel::factory()->toTest()->create()->id,
            reason: 'Motivo do cancelamento'
        );

        ($transaction)($input);

        $this->assertDatabaseCount('transactions', 1);
        $this->assertDatabaseHas('transactions', [
            'status' =>  StatusTransactionType::Canceled->value,
            'cancel_description' =>  'Motivo do cancelamento',
        ]);
    }
}
