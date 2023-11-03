<?php

namespace Tests\Integration\UseCase\Transaction;

use App\Models\BankAccount as BankAccountModel;
use App\Models\PixKey as PixKeyModel;
use App\Models\Transaction as TransactionModel;
use Core\Application\UseCase\Transaction\Paginate\PaginateTransactionInputDto;
use Core\Application\UseCase\Transaction\Paginate\PaginateTransactionUseCase;
use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Domain\Shared\Repository\PaginationInterface;
use Core\Infrastructure\Persistence\Eloquent\Repository\BankAccountRepositoryDb;
use Tests\TestCase;

class PaginateTransactionUseCaseTest extends TestCase
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

    public function test_paginate_pix_keys_account()
    {
        $bankAccount = BankAccountModel::factory()->create();
        TransactionModel::factory()->toTest()->count(20)->create([
            'bank_account_from_id' => $bankAccount->id,
        ]);

        $useCase = new PaginateTransactionUseCase(bankAccountRepository: $this->bankAccountRepository);
        $result = ($useCase)(input: new PaginateTransactionInputDto(bankAccountId: $bankAccount->id));

        $this->assertInstanceOf(PaginationInterface::class, $result);
        $this->assertCount(15, $result->items());
    }
}
