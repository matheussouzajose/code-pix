<?php

namespace Core\Ui\Factories\UseCase;

use Core\Application\UseCase\Transaction\Status\SaveConfirmTransactionUseCase;
use Core\Ui\Factories\Repository\TransactionRepositoryFactory;

class SaveConfirmTransactionFactory
{
    public static function create(): SaveConfirmTransactionUseCase
    {
        return new SaveConfirmTransactionUseCase(
            transactionRepository: TransactionRepositoryFactory::create()
        );
    }
}
