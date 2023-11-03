<?php

namespace Core\Ui\Factories\UseCase;

use Core\Application\UseCase\Transaction\Create\CreateTransactionUseCase;
use Core\Ui\Factories\Event\TransactionEventManagerFactory;
use Core\Ui\Factories\Repository\PixKeyRepositoryFactory;
use Core\Ui\Factories\Repository\TransactionDbFactory;
use Core\Ui\Factories\Repository\TransactionRepositoryFactory;

class CreateTransactionUseCaseFactory
{
    public static function create(): CreateTransactionUseCase
    {
        return new CreateTransactionUseCase(
            transactionRepository: TransactionRepositoryFactory::create(),
            pixKeyRepository: PixKeyRepositoryFactory::create(),
            transactionDb: TransactionDbFactory::create(),
            eventManager: TransactionEventManagerFactory::create()
        );
    }
}
