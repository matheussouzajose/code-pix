<?php

namespace Core\Ui\Factories\Controller\BankAccount;

use Core\Ui\Api\Controllers\BankAccount\ShowBankAccountController;
use Core\Ui\Factories\UseCase\BankAccount\ShowBankAccountUseCaseFactory;

class ShowBankAccountControllerFactory
{
    public static function create(): ShowBankAccountController
    {
        return new ShowBankAccountController(
            showBankAccountUseCase: ShowBankAccountUseCaseFactory::create()
        );
    }
}
