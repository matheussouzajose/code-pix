<?php

namespace Core\Ui\Factories\Repository;

use Core\Domain\Shared\Repository\TransactionInterface;
use Core\Infrastructure\Persistence\Eloquent\Transaction\TransactionDb;

class TransactionDbFactory
{
    public static function create(): TransactionInterface
    {
        return new TransactionDb();
    }
}
