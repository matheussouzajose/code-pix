<?php

namespace Core\Ui\Factories\UseCase;

use Core\Application\UseCase\Transaction\Status\SaveCompleteTransactionUseCase;
use Core\Ui\Factories\Repository\TransactionRepositoryFactory;

class SaveCompleteTransactionFactory
{
    public static function create(): SaveCompleteTransactionUseCase
    {
        return new SaveCompleteTransactionUseCase(
            transactionRepository: TransactionRepositoryFactory::create()
        );
    }
}
