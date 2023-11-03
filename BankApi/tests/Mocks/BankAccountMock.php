<?php

namespace Tests\Mocks;

use Core\Domain\BankAccount\Entity\BankAccount;
use Core\Domain\Shared\Exception\NotificationException;

class BankAccountMock
{
    /**
     * @throws NotificationException
     */
    public static function mock(): BankAccount
    {
        return new BankAccount(
            number: '1111',
            ownerName: 'Matheus',
            balance: 5000
        );
    }
}
