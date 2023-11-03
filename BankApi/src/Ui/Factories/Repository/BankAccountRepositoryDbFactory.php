<?php

namespace Core\Ui\Factories\Repository;

use App\Models\BankAccount;
use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Infrastructure\Persistence\Eloquent\Repository\BankAccountRepositoryDb;

class BankAccountRepositoryDbFactory
{
    public static function create(): BankAccountRepositoryInterface
    {
        return new BankAccountRepositoryDb(
            bankAccountModel: new BankAccount()
        );
    }
}
