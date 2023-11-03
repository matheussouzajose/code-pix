<?php

namespace Core\Domain\Transaction\Factory;

use Core\Domain\Shared\Validator\ValidatorInterface;
use Core\Domain\Transaction\Validator\TransactionValidator;

class TransactionValidatorFactory
{
    public static function create(): ValidatorInterface
    {
        return new TransactionValidator();
    }
}
