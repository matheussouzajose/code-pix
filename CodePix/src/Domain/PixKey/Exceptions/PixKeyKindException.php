<?php

namespace Core\Domain\PixKey\Exceptions;

class PixKeyKindException extends \Exception
{
    public static function alreadyExists(string $kind, string $key): self
    {
        $message = sprintf('%s %s already in use.', $kind, $key);
        return new self(
            message: $message,
            code: 403
        );
    }
}
