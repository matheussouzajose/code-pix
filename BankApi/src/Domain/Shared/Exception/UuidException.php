<?php

namespace Core\Domain\Shared\Exception;

class UuidException extends \InvalidArgumentException
{
    public static function itemInvalid(string $id): UuidException
    {
        $message = sprintf('The %s is invalid.', $id);

        return new self(
            message: $message,
            code: 403
        );
    }
}
