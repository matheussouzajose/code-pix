<?php

namespace Core\Ui\Factories\UseCase;

use Core\Application\UseCase\Transaction\Status\SaveErrorTransactionUseCase;
use Core\Ui\Factories\Repository\TransactionRepositoryFactory;

class SaveErrorTransactionFactory
{
    public static function create(): SaveErrorTransactionUseCase
    {
        return new SaveErrorTransactionUseCase(
            transactionRepository: TransactionRepositoryFactory::create()
        );
    }
}
