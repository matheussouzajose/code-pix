<?php

namespace Tests\Unit\Domain;

use Core\Domain\BankAccount\Entity\BankAccount;
use Core\Domain\BankAccount\Validator\BankAccountValidator;
use Core\Domain\Shared\Exception\NotificationException;
use Tests\Mocks\BankAccountMock;
use Tests\TestCase;

class BankAccountUnitTest extends TestCase
{
    public function test_new_bank_account()
    {
        $bankAccount = BankAccountMock::mock();

        $this->assertNotEmpty($bankAccount->id());
        $this->assertNotEmpty($bankAccount->createdAt());

        $this->assertEquals('1111', $bankAccount->number);
        $this->assertEquals('Matheus', $bankAccount->ownerName);
        $this->assertEquals(5000, $bankAccount->balance);

    }

    public function test_update_balance()
    {
        $bankAccount = BankAccountMock::mock();

        $bankAccount->incrementBalance(1000.00);
        $this->assertEquals(6000.00, $bankAccount->balance);

        $bankAccount->decrementBalance(500.00);
        $this->assertEquals(5500.00, $bankAccount->balance);
    }

    /**
     * @throws NotificationException
     */
    public function test_validator()
    {
        $this->expectExceptionObject(NotificationException::messages(BankAccountValidator::CONTEXT));

        new BankAccount(
            number: '',
            ownerName: '',
            balance: 0,
        );
    }
}
