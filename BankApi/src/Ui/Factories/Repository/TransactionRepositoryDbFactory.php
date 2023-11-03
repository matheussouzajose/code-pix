<?php

namespace Core\Ui\Factories\Repository;

use App\Models\Transaction;
use Core\Domain\Transaction\Repository\TransactionRepositoryInterface;
use Core\Infrastructure\Persistence\Eloquent\Repository\TransactionRepositoryDb;

class TransactionRepositoryDbFactory
{
    public static function create(): TransactionRepositoryInterface
    {
        return new TransactionRepositoryDb(
            transactionModel: new Transaction()
        );
    }
}
