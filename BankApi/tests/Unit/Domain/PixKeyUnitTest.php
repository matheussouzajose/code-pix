<?php

namespace Tests\Unit\Domain;

use Core\Domain\BankAccount\Validator\BankAccountValidator;
use Core\Domain\PixKey\Entity\PixKey;
use Core\Domain\PixKey\Enum\PixKeyKind;
use Core\Domain\Shared\Exception\NotificationException;
use Tests\Mocks\BankAccountMock;
use Tests\Mocks\PixKeyMock;
use Tests\TestCase;

class PixKeyUnitTest extends TestCase
{
    /**
     * @throws NotificationException
     */
    public function test_new_pix_key()
    {
        $pixAccount = PixKeyMock::mock();

        $this->assertNotEmpty($pixAccount->id());
        $this->assertNotEmpty($pixAccount->createdAt());
        $this->assertNotEmpty($pixAccount->bankAccountId());

        $this->assertEquals('matheus@mail.com', $pixAccount->key);
        $this->assertEquals(PixKeyKind::email, $pixAccount->kind);
    }

    /**
     * @throws NotificationException
     */
    public function test_validator()
    {
        $this->expectExceptionObject(NotificationException::messages(BankAccountValidator::CONTEXT));

        new PixKey(
            key: '',
            kind: PixKeyKind::email,
            bankAccount: BankAccountMock::mock()
        );
    }
}
