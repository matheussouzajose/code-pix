<?php

namespace Core\Ui\Factories\UseCase\PixKey;

use Core\Application\UseCase\PixKey\Create\CreatePixKeyUseCase;
use Core\Ui\Factories\Http\HttpIntegrationServiceFactory;
use Core\Ui\Factories\Repository\BankAccountRepositoryDbFactory;
use Core\Ui\Factories\Repository\PixKeyRepositoryDbFactory;
use Core\Ui\Factories\Repository\TransactionDbFactory;

class CreatePixKeyUseCaseFactory
{
    public static function create(): CreatePixKeyUseCase
    {
        return new CreatePixKeyUseCase(
            bankAccountRepository: BankAccountRepositoryDbFactory::create(),
            pixKeyInterfaceRepository: PixKeyRepositoryDbFactory::create(),
            transaction: TransactionDbFactory::create(),
            httpIntegrationService: HttpIntegrationServiceFactory::create()
        );
    }
}
