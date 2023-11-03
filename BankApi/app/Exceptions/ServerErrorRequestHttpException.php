<?php

namespace App\Exceptions;

class ServerErrorRequestHttpException extends \Exception
{
    public static function message(): ServerErrorRequestHttpException
    {
        return new self(
            message: 'an error occurred on the server',
            code: 500
        );
    }
}
