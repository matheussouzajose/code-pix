<?php

namespace Tests\Mocks;

use Core\Domain\PixKey\Entity\PixKey;
use Core\Domain\PixKey\Enum\PixKeyKind;
use Core\Domain\Shared\Exception\NotificationException;

class PixKeyMock
{
    /**
     * @throws NotificationException
     */
    public static function mock(): PixKey
    {
        return new PixKey(
            key: 'matheus@mail.com',
            kind: PixKeyKind::email,
            bankAccount: BankAccountMock::mock()
        );
    }
}
