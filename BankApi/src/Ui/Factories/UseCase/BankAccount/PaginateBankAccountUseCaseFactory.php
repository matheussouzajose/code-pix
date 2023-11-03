<?php

namespace Core\Ui\Factories\UseCase\BankAccount;

use Core\Application\UseCase\BankAccount\Paginate\PaginateBankAccountUseCase;
use Core\Ui\Factories\Repository\BankAccountRepositoryDbFactory;

class PaginateBankAccountUseCaseFactory
{
    public static function create(): PaginateBankAccountUseCase
    {
        return new PaginateBankAccountUseCase(
            bankAccountRepository: BankAccountRepositoryDbFactory::create()
        );
    }
}
