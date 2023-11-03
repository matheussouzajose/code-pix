<?php

namespace Core\Ui\Factories\UseCase;

use Core\Application\UseCase\Transaction\Status\SaveTransactionUseCase;
use Core\Ui\Factories\Event\TransactionEventManagerFactory;
use Core\Ui\Factories\Repository\TransactionDbFactory;
use Core\Ui\Factories\Repository\TransactionRepositoryFactory;

class SaveTransactionUseCaseFactory
{
    public static function create(): SaveTransactionUseCase
    {
        return new SaveTransactionUseCase(
            transactionRepository: TransactionRepositoryFactory::create(),
            transactionDb: TransactionDbFactory::create(),
            eventManager: TransactionEventManagerFactory::create()
        );
    }
}
