<?php

namespace Tests\Unit\Mocks;

use Core\Domain\PixKey\Entity\PixKey;
use Core\Domain\PixKey\Enum\KindType;
use Core\Domain\PixKey\Enum\StatusType;
use Core\Domain\Shared\Exception\NotificationException;

class PixKeyMock
{
    /**
     * @throws NotificationException
     */
    public static function mock(): PixKey
    {
        return new PixKey(
            kind: KindType::Email,
            key: 'matheus@mail.com',
            account: AccountMock::mock(),
            status: StatusType::Active
        );
    }
}
