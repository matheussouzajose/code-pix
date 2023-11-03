<?php

namespace Core\Ui\Factories\UseCase\PixKey;

use Core\Application\UseCase\PixKey\Exist\ExistPixKeyUseCase;
use Core\Ui\Factories\Http\HttpIntegrationServiceFactory;
use Core\Ui\Factories\Repository\BankAccountRepositoryDbFactory;

class ExistPixKeyUseCaseFactory
{
    public static function create(): ExistPixKeyUseCase
    {
        return new ExistPixKeyUseCase(
            bankAccountRepository: BankAccountRepositoryDbFactory::create(),
            httpIntegrationService: HttpIntegrationServiceFactory::create()
        );
    }
}
