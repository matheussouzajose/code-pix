<?php

namespace Core\Domain\Transaction\Factory;

use Core\Domain\Shared\Validation\ValidatorEntityInterface;
use Core\Domain\Transaction\Validator\TransactionValidator;

class TransactionValidatorFactory
{
    public static function create(): ValidatorEntityInterface
    {
        return new TransactionValidator();
    }
}
