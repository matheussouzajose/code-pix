<?php

namespace Core\Ui\Factories\Repository;

use App\Models\Account;
use App\Models\Bank;
use App\Models\PixKey;
use Core\Infrastructure\Persistence\Eloquent\Repository\PixKeyRepositoryDb;

class PixKeyRepositoryFactory
{
    public static function create(): PixKeyRepositoryDb
    {
        return new PixKeyRepositoryDb(
            pixKeyModel: new PixKey(),
            bankModel: new Bank(),
            accountModel: new Account()
        );
    }
}
