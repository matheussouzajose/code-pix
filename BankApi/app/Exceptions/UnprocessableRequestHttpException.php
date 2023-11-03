<?php

namespace App\Exceptions;

class UnprocessableRequestHttpException extends \Exception
{
    public static function message(string $message): UnprocessableRequestHttpException
    {
        return new self(
            message: $message,
            code: 422
        );
    }
}
