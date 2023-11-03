<?php

namespace Core\Ui\Factories\UseCase\Transaction;

use Core\Application\UseCase\Transaction\Paginate\PaginateTransactionUseCase;
use Core\Ui\Factories\Repository\BankAccountRepositoryDbFactory;
use Core\Ui\Factories\Repository\TransactionRepositoryDbFactory;

class PaginateTransactionUseCaseFactory
{
    public static function create(): PaginateTransactionUseCase
    {
        return new PaginateTransactionUseCase(
            transactionRepository: TransactionRepositoryDbFactory::create(),
            bankAccountRepository: BankAccountRepositoryDbFactory::create()
        );
    }
}
