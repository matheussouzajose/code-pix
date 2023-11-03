<?php

namespace tests\Unit\Domain;

use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Transaction\Entity\Transaction;
use Core\Domain\Transaction\Enum\StatusTransactionType;
use Tests\TestCase;
use Tests\Unit\Mocks\AccountMock;
use Tests\Unit\Mocks\PixKeyMock;

class TransactionUnitTest extends TestCase
{
    /**
     * @throws NotificationException
     */
    public function test_transaction_success()
    {
        $transaction = new Transaction(
            accountFrom: AccountMock::mock(),
            amount: 1000,
            pixKeyTo: PixKeyMock::mock(),
            description: 'Pgto Academia'
        );

        $this->assertNotEmpty($transaction->id());
        $this->assertNotEmpty($transaction->createdAt());
    }

    /**
     * @throws NotificationException
     */
    public function test_throws_error_when_validation_failure()
    {
        $this->expectExceptionObject(NotificationException::messages('transaction'));

        new Transaction(
            accountFrom: AccountMock::mock(),
            amount: -1,
            pixKeyTo: PixKeyMock::mock(),
            description: ''
        );
    }

    /**
     * @throws NotificationException
     */
    public function test_status_success()
    {
        $transaction = new Transaction(
            accountFrom: AccountMock::mock(),
            amount: 1000,
            pixKeyTo: PixKeyMock::mock(),
            description: 'Pgto Academia'
        );

        $this->assertEquals(StatusTransactionType::Pending, $transaction->status());
        $this->assertEmpty($transaction->updatedAt());

        $transaction->completed();
        $this->assertEquals(StatusTransactionType::Completed, $transaction->status());
        $this->assertNotEmpty($transaction->updatedAt());

        $transaction->confirmed();
        $this->assertEquals(StatusTransactionType::Confirmed, $transaction->status());
        $this->assertNotEmpty($transaction->updatedAt());

        $transaction->canceled('Motivo X');
        $this->assertEquals(StatusTransactionType::Canceled, $transaction->status());
        $this->assertEquals('Motivo X', $transaction->cancelDescription());
        $this->assertNotEmpty($transaction->updatedAt());
    }
}
