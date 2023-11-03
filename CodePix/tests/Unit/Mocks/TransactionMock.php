<?php

namespace Tests\Unit\Mocks;

use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Transaction\Entity\Transaction;

class TransactionMock
{
    /**
     * @throws NotificationException
     */
    public static function mock(): Transaction
    {
        return new Transaction(
            accountFrom: AccountMock::mock(),
            amount: 100,
            pixKeyTo: PixKeyMock::mock(),
            description: 'Description'
        );
    }
}
