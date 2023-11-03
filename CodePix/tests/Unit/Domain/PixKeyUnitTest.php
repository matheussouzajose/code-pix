<?php

namespace tests\Unit\Domain;

use Core\Domain\PixKey\Entity\PixKey;
use Core\Domain\PixKey\Enum\KindType;
use Core\Domain\PixKey\Enum\StatusType;
use Core\Domain\Shared\Exception\NotificationException;
use Tests\TestCase;
use Tests\Unit\Mocks\AccountMock;
use Tests\Unit\Mocks\TransactionMock;

class PixKeyUnitTest extends TestCase
{
    /**
     * @throws NotificationException
     */
    public function test_bank_success()
    {
        $pixKey = new PixKey(
            kind: KindType::Email,
            key: '12345678910',
            account: AccountMock::mock(),
            status: StatusType::Active
        );

        $this->assertNotEmpty($pixKey->id());
        $this->assertNotEmpty($pixKey->createdAt());
    }

    /**
     * @throws NotificationException
     */
    public function test_throws_error_when_validation_failure()
    {
        $this->expectExceptionObject(NotificationException::messages('pix_key'));

        new PixKey(
            kind: KindType::Email,
            key: '',
            account: AccountMock::mock(),
            status: StatusType::Active
        );
    }

    /**
     * @throws NotificationException
     */
    public function test_add_transaction(): void
    {
        $pixKey = new PixKey(
            kind: KindType::Email,
            key: 'matheus.jose@mail.com',
            account: AccountMock::mock(),
            status: StatusType::Active,
        );

        $transaction = TransactionMock::mock();
        $pixKey->addTransaction(transaction: $transaction);

        $this->assertCount(1, $pixKey->transactions());

        $pixKey->removeTransaction(transaction: $transaction);
        $this->assertCount(0, $pixKey->transactions());
    }
}
