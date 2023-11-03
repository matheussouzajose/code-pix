<?php

namespace Core\Ui\Factories\UseCase\Transaction;

use Core\Application\UseCase\Transaction\Save\SaveTransactionUseCase;
use Core\Ui\Factories\Event\TransactionEventManagerFactory;
use Core\Ui\Factories\Repository\BankAccountRepositoryDbFactory;
use Core\Ui\Factories\Repository\PixKeyRepositoryDbFactory;
use Core\Ui\Factories\Repository\TransactionDbFactory;
use Core\Ui\Factories\Repository\TransactionRepositoryDbFactory;

class SaveTransactionUseCaseFactory
{
    public static function create(): SaveTransactionUseCase
    {
        return new SaveTransactionUseCase(
            bankAccountRepository: BankAccountRepositoryDbFactory::create(),
            transactionRepository: TransactionRepositoryDbFactory::create(),
            pixKeyRepository: PixKeyRepositoryDbFactory::create(),
            transactionDb: TransactionDbFactory::create(),
            eventManager: TransactionEventManagerFactory::create()
        );
    }
}
