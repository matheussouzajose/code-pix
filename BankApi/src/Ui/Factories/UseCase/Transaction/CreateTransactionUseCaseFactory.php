<?php

namespace Core\Ui\Factories\UseCase\Transaction;

use Core\Application\UseCase\Transaction\Create\CreateTransactionUseCase;
use Core\Ui\Factories\Event\TransactionEventManagerFactory;
use Core\Ui\Factories\Http\HttpIntegrationServiceFactory;
use Core\Ui\Factories\Repository\BankAccountRepositoryDbFactory;
use Core\Ui\Factories\Repository\TransactionDbFactory;
use Core\Ui\Factories\Repository\TransactionRepositoryDbFactory;

class CreateTransactionUseCaseFactory
{
    public static function create(): CreateTransactionUseCase
    {
        return new CreateTransactionUseCase(
            transactionRepository: TransactionRepositoryDbFactory::create(),
            bankAccountRepository: BankAccountRepositoryDbFactory::create(),
            transactionDb: TransactionDbFactory::create(),
            eventManager: TransactionEventManagerFactory::create(),
            httpIntegrationService: HttpIntegrationServiceFactory::create()
        );
    }
}
