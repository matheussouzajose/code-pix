<?php

namespace Core\Domain\Shared\Exception;

class PropertyClassException extends \InvalidArgumentException
{
    public static function propertyNotFound(string $property, string $className): PropertyClassException
    {
        $message = sprintf('Property %s not found in class %s', $property, $className);

        return new self(
            message: $message,
            code: 403
        );
    }
}
