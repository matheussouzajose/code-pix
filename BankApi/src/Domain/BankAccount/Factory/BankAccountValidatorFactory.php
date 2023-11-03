<?php

namespace Core\Domain\BankAccount\Factory;

use Core\Domain\BankAccount\Validator\BankAccountValidator;

class BankAccountValidatorFactory
{
    public static function create(): BankAccountValidator
    {
        return new BankAccountValidator();
    }
}
