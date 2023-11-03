<?php

namespace Tests\Unit\Mocks;

use Core\Domain\Account\Entity\Account;
use Core\Domain\Shared\Exception\NotificationException;

class AccountMock
{
    /**
     * @throws NotificationException
     */
    public static function mock(): Account
    {
        return new Account(
            ownerName: 'Matheus',
            number: '123456',
            bank: BankMock::mock(),
        );
    }
}
