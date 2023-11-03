<?php

namespace Core\Domain\Shared\Exception;

class TheSameAccountException extends \InvalidArgumentException
{
    public static function invalid(): TheSameAccountException
    {
        return new self(
            message: 'The source and destination account cannot be the same.',
            code: 422
        );
    }
}
