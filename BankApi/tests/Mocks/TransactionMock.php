<?php

namespace Tests\Mocks;

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
            bankAccountFrom: BankAccountMock::mock(),
            pixKeyTo: PixKeyMock::mock(),
            amount: 5000,
            description: 'Descrição do pagamento'
        );
    }
}
