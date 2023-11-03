<?php

namespace Core\Domain\Transaction\Enum;

enum StatusTransactionType: string
{
    case Pending = 'pending';
    case Completed = 'completed';
    case Canceled = 'canceled';
    case Confirmed = 'confirmed';
}
