<?php

namespace Tests\Unit\Domain;

use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Transaction\Entity\Transaction;
use Core\Domain\Transaction\Validator\TransactionValidator;
use Tests\Mocks\BankAccountMock;
use Tests\Mocks\PixKeyMock;
use Tests\Mocks\TransactionMock;
use Tests\TestCase;

class TransactionUnitTest extends TestCase
{
    /**
     * @throws NotificationException
     */
    public function test_new_transaction()
    {
        $transaction = TransactionMock::mock();

        $this->assertNotEmpty($transaction->id());
        $this->assertNotEmpty($transaction->externalId);
        $this->assertNotEmpty($transaction->createdAt());
        $this->assertNotEmpty($transaction->bankAccountId());
        $this->assertNotEmpty($transaction->pixKeyToKey());
        $this->assertNotEmpty($transaction->pixKeyToKind());

        $this->assertEquals('Descrição do pagamento', $transaction->description);
        $this->assertEquals(5000, $transaction->amount);
    }

    /**
     * @throws NotificationException
     */
    public function test_required_validator()
    {
        $this->expectExceptionObject(NotificationException::messages(TransactionValidator::CONTEXT));

        new Transaction(
            bankAccountFrom: BankAccountMock::mock(),
            pixKeyTo: PixKeyMock::mock(),
            amount: 0,
            description: '',
        );
    }

    /**
     * @throws NotificationException
     */
    public function test_without_limit_validator()
    {
        $this->expectExceptionObject(NotificationException::messages(TransactionValidator::CONTEXT));

        new Transaction(
            bankAccountFrom: BankAccountMock::mock(),
            pixKeyTo: PixKeyMock::mock(),
            amount: 10000,
            description: 'Descrição do pagamento',
        );
    }
}
