<?php

namespace Core\Ui\Factories\UseCase\PixKey;

use Core\Application\UseCase\PixKey\Paginate\PaginatePixKeyUseCase;
use Core\Ui\Factories\Repository\BankAccountRepositoryDbFactory;
use Core\Ui\Factories\Repository\PixKeyRepositoryDbFactory;

class PaginatePixKeyUseCaseFactory
{
    public static function create(): PaginatePixKeyUseCase
    {
        return new PaginatePixKeyUseCase(
            pixKeyInterfaceRepository: PixKeyRepositoryDbFactory::create(),
            bankAccountRepository: BankAccountRepositoryDbFactory::create()
        );
    }
}
