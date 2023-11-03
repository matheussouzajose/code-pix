<?php

namespace Tests\Integration\UseCase\BankAccount;

use App\Models\BankAccount as BankAccountModel;
use App\Models\PixKey as PixKeyModel;
use Core\Application\UseCase\BankAccount\Paginate\PaginateBankAccountUseCase;
use Core\Application\UseCase\Shared\Dto\PaginateInputDto;
use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Domain\Shared\Repository\PaginationInterface;
use Core\Infrastructure\Persistence\Eloquent\Repository\BankAccountRepositoryDb;
use Tests\TestCase;

class PaginateAccountBankUseCaseTest extends TestCase
{
    protected BankAccountRepositoryInterface $bankAccountRepository;

    protected function setUp(): void
    {
        $this->bankAccountRepository = new BankAccountRepositoryDb(
            bankAccountModel: new BankAccountModel(),
            pixKeyModel: new PixKeyModel()
        );

        parent::setUp();
    }

    public function test_paginate_bank_account()
    {
        BankAccountModel::factory()->count(20)->create();

        $useCase = new PaginateBankAccountUseCase(bankAccountRepository: $this->bankAccountRepository);
        $result = ($useCase)(input: new PaginateInputDto());

        $this->assertInstanceOf(PaginationInterface::class, $result);
        $this->assertCount(15, $result->items());
    }
}
