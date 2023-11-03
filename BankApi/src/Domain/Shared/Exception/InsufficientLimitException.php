<?php

namespace Core\Domain\Shared\Exception;

class InsufficientLimitException extends \InvalidArgumentException
{
    public static function invalid(): InsufficientLimitException
    {
        return new self(
            message: 'You have no limit to complete this transaction.',
            code: 422
        );
    }
}
