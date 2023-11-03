<?php

namespace Core\Domain\Transaction\Enum;

enum TransactionOperation: string
{
    case Credit = 'credit';
    case Debit = 'debit';
}
