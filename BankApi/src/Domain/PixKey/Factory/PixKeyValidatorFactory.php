<?php

namespace Core\Domain\PixKey\Factory;

use Core\Domain\PixKey\Validator\PixKeyValidator;
use Core\Domain\Shared\Validator\ValidatorInterface;

class PixKeyValidatorFactory
{
    public static function create(): ValidatorInterface
    {
        return new PixKeyValidator();
    }
}
