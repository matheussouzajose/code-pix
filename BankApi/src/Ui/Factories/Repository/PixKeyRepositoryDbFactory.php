<?php

namespace Core\Ui\Factories\Repository;

use App\Models\PixKey;
use Core\Domain\PixKey\Repository\PixKeyInterfaceRepository;
use Core\Infrastructure\Persistence\Eloquent\Repository\PixKeyRepositoryDb;

class PixKeyRepositoryDbFactory
{
    public static function create(): PixKeyInterfaceRepository
    {
        return new PixKeyRepositoryDb(
            pixKeyModel: new PixKey()
        );
    }
}
