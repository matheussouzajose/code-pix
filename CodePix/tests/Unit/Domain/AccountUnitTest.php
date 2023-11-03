<?php

namespace tests\Unit\Domain;

use Core\Domain\Account\Entity\Account;
use Core\Domain\Shared\Exception\NotificationException;
use Tests\TestCase;
use Tests\Unit\Mocks\BankMock;
use Tests\Unit\Mocks\PixKeyMock;

class AccountUnitTest extends TestCase
{
    /**
     * @throws NotificationException
     */
    public function test_bank_success()
    {
        $account = new Account(
            ownerName: 'Matheus Souza Jose',
            number: '12345678910',
            bank: BankMock::mock(),
        );

        $this->assertNotEmpty($account->id());
        $this->assertNotEmpty($account->createdAt());
        $this->assertEquals('Matheus Souza Jose', $account->ownerName);
        $this->assertEquals('12345678910', $account->number);
    }

    /**
     * @throws NotificationException
     */
    public function test_throws_error_when_validation_failure()
    {
        $this->expectExceptionObject(NotificationException::messages('account'));

        new Account(
            ownerName: '',
            number: '',
            bank: BankMock::mock(),
        );
    }

    /**
     * @throws NotificationException
     */
    public function test_add_pix_key(): void
    {
        $account = new Account(
            ownerName: 'Matheus Souza',
            number: '123456',
            bank: BankMock::mock(),
        );

        $pixKeyEmail = PixKeyMock::mock();
        $account->addPixKey(pixKey:  $pixKeyEmail);

        $this->assertCount(1, $account->pixKeys());

        $account->removePixKey(pixKey: $pixKeyEmail);
        $this->assertCount(0, $account->pixKeys());
    }
}
