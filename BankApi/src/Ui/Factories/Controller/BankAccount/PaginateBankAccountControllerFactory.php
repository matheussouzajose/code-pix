<?php

namespace Core\Ui\Factories\Controller\BankAccount;

use Core\Ui\Api\Controllers\BankAccount\PaginateBankAccountController;
use Core\Ui\Factories\UseCase\BankAccount\PaginateBankAccountUseCaseFactory;

class PaginateBankAccountControllerFactory
{
    public static function create(): PaginateBankAccountController
    {
        return new PaginateBankAccountController(
            paginateBankAccountUseCase: PaginateBankAccountUseCaseFactory::create()
        );
    }
}
