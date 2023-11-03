<?php

namespace Tests\Unit\Mocks;

use Core\Domain\Bank\Entity\Bank;

class BankMock
{
    public static function mock(): Bank
    {
        return new Bank(
            code: '123',
            name: 'CodeBank'
        );
    }
}
