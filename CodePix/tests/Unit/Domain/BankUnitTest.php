<?php

namespace tests\Unit\Domain;

use Core\Domain\Bank\Entity\Bank;
use Core\Domain\Shared\Exception\NotificationException;
use Tests\TestCase;
use Tests\Unit\Mocks\AccountMock;

class BankUnitTest extends TestCase
{
    public function test_bank_success()
    {
        $bank = new Bank(
            code: '001',
            name: 'CodeBank'
        );

        $this->assertNotEmpty($bank->id());
        $this->assertNotEmpty($bank->createdAt());
        $this->assertEquals('001', $bank->code);
        $this->assertEquals('CodeBank', $bank->name);
    }

    public function test_throws_error_when_validation_failure()
    {
        $this->expectExceptionObject(NotificationException::messages('bank'));

        new Bank(
            code: '',
            name: ''
        );
    }

    /**
     * @throws NotificationException
     */
    public function test_add_account(): void
    {
        $bank = new Bank(
            code: '001',
            name: 'CodeBank'
        );

        $account = AccountMock::mock();
        $bank->addAccount(account: $account);

        $this->assertCount(1, $bank->accounts());

        $bank->removeAccount(account: $account);
        $this->assertCount(0, $bank->accounts());
    }
}
