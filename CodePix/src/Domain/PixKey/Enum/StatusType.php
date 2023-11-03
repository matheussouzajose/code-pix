<?php

namespace Core\Domain\PixKey\Enum;

enum StatusType: string
{
    case Active = 'active';

    case Inactive = 'inactive';
}
