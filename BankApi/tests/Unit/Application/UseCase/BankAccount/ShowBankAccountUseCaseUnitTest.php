<?php

namespace Tests\Unit\Application\UseCase\BankAccount;

use Core\Application\UseCase\BankAccount\Show\ShowBankAccountInputDto;
use Core\Application\UseCase\BankAccount\Show\ShowBankAccountOutputDto;
use Core\Application\UseCase\BankAccount\Show\ShowBankAccountUseCase;
use Core\Domain\BankAccount\Entity\BankAccount;
use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;
use Core\Infrastructure\Exceptions\NotFoundException;
use Tests\TestCase;

class ShowBankAccountUseCaseUnitTest extends TestCase
{
    public function test_throws_error_account()
    {
        $this->expectExceptionObject(NotFoundException::itemNotFound(''));

        $bankAccountRepository = \Mockery::spy(\stdClass::class, BankAccountRepositoryInterface::class);
        $bankAccountRepository->shouldReceive('findById')->andThrow(NotFoundException::itemNotFound(''));

        $useCase = new ShowBankAccountUseCase(bankAccountRepository: $bankAccountRepository);
        ($useCase)(
            input: new ShowBankAccountInputDto(
                id: Uuid::random()
            )
        );
    }

    /**
     * @throws NotificationException
     */
    public function test_show_bank_account()
    {
        $bankAccount = new BankAccount(
            number: '1111',
            ownerName: 'Matheus',
            balance: 1000,
        );

        $bankAccountRepository = \Mockery::spy(\stdClass::class, BankAccountRepositoryInterface::class);
        $bankAccountRepository->shouldReceive('findById')->andReturn($bankAccount);

        $useCase = new ShowBankAccountUseCase(bankAccountRepository: $bankAccountRepository);
        $result = ($useCase)(
            input: new ShowBankAccountInputDto(
                id: Uuid::random()
            )
        );

        $this->assertInstanceOf(ShowBankAccountOutputDto::class, $result);
    }
}
