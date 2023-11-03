<?php

namespace Core\Infrastructure\Exceptions;

class NotFoundException extends \Exception
{
    public static function itemNotFound(string $item): NotFoundException
    {
        $message = sprintf('The item %s not found', $item);
        return new self(
            message: $message,
            code: 403
        );
    }
}
