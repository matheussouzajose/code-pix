<?php

namespace Core\Domain\Transaction\Enum;

enum TransactionStatus: string
{
    case Pending = 'pending';
    case Completed = 'completed';
    case Confirmed = 'confirmed';
    case Error = 'error';
}
