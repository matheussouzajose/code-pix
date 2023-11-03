<?php

namespace Core\Domain\PixKey\Factory;

use Core\Domain\PixKey\Validator\PixKeyValidator;
use Core\Domain\Shared\Validation\ValidatorEntityInterface;

class PixKeyValidatorFactory
{
    public static function create(): ValidatorEntityInterface
    {
        return new PixKeyValidator();
    }

}
