<?php

namespace Core\Domain\PixKey\Enum;

enum KindType: string
{
    case Email = 'email';

    case Cpf = 'cpf';
}
