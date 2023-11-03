<?php

namespace Core\Domain\Shared\Exception;

class NotificationException extends \Exception
{
    public static function messages(string $messages): NotificationException
    {
        return new self(
            message: $messages,
            code: 403
        );
    }
}
