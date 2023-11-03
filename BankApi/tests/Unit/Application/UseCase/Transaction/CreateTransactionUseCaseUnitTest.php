<?php

namespace Tests\Unit\Application\UseCase\Transaction;

use Core\Application\UseCase\PixKey\Create\CreatePixKeyOutputDto;
use Core\Application\UseCase\Transaction\Create\CreateTransactionInputDto;
use Core\Application\UseCase\Transaction\Create\CreateTransactionUseCase;
use Core\Domain\BankAccount\Entity\BankAccount;
use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Domain\PixKey\Entity\PixKey;
use Core\Domain\PixKey\Enum\PixKeyKind;
use Core\Domain\Shared\Exception\NotificationException;
use Tests\TestCase;

class CreateTransactionUseCaseUnitTest extends TestCase
{
    /**
     * @throws NotificationException
     */
    public function test_create_pix_kind()
    {
        //        $bankAccount = new BankAccount(number: '1111', ownerName: 'Matheus');
        //        $pixKey = new PixKey(
        //            key: 'matheus@mail.com',
        //            kind: PixKeyKind::email,
        //            bankAccount: $bankAccount
        //        );
        //
        //        $bankAccountRepository = \Mockery::mock(\stdClass::class, BankAccountRepositoryInterface::class);
        //        $bankAccountRepository->shouldReceive('createPixKey')->andReturn($pixKey);
        //        $bankAccountRepository->shouldReceive('findById')->andReturn($bankAccount);
        //
        //        $useCase = new CreateTransactionUseCase($bankAccountRepository);
        //        $result = ($useCase)(
        //            input: new CreateTransactionInputDto(
        //                bankAccountId: $pixKey->bankAccountId(),
        //                kind: PixKeyKind::email->value,
        //                key: 'matheus@gmail.com'
        //            )
        //        );
        //
        //        $this->assertInstanceOf(CreatePixKeyOutputDto::class, $result);
        //        $this->assertEquals($pixKey->id(), $result->id);
        //        $this->assertEquals($pixKey->kind->value, $result->kind);
        //        $this->assertEquals($pixKey->key, $result->key);
        //        $this->assertEquals($bankAccount, $result->bankAccount);
        //        $this->assertEquals($pixKey->createdAt(), $result->createdAt);
    }
}
