<?php

namespace Core\Domain\PixKey\Enum;

enum PixKeyKind: string
{
    case email = 'email';
    case cpf = 'cpf';
}
