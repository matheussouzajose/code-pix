<?php

namespace Core\Ui\Factories\Repository;

use App\Models\Transaction;
use Core\Infrastructure\Persistence\Eloquent\Repository\TransactionRepositoryDb;

class TransactionRepositoryFactory
{
    public static function create(): TransactionRepositoryDb
    {
        return new TransactionRepositoryDb(
            transactionModel: new Transaction()
        );
    }
}
