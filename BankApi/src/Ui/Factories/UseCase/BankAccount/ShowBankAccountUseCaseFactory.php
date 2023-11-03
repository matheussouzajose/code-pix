<?php

namespace Core\Ui\Factories\UseCase\BankAccount;

use Core\Application\UseCase\BankAccount\Show\ShowBankAccountUseCase;
use Core\Ui\Factories\Repository\BankAccountRepositoryDbFactory;

class ShowBankAccountUseCaseFactory
{
    public static function create(): ShowBankAccountUseCase
    {
        return new ShowBankAccountUseCase(
            bankAccountRepository: BankAccountRepositoryDbFactory::create()
        );
    }
}
