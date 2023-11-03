<?php

namespace Core\Domain\Bank\Factory;

use Core\Domain\Bank\Validator\BankValidator;
use Core\Domain\Shared\Validation\ValidatorEntityInterface;

class BankValidatorFactory
{
    public static function create(): ValidatorEntityInterface
    {
        return new BankValidator();
    }
}
