<?php

namespace Tests\Integration\UseCase\PixKey;

use App\Models\BankAccount as BankAccountModel;
use App\Models\PixKey as PixKeyModel;
use Core\Application\UseCase\PixKey\Paginate\PaginatePixKeyInputDto;
use Core\Application\UseCase\PixKey\Paginate\PaginatePixKeyUseCase;
use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Domain\Shared\Repository\PaginationInterface;
use Core\Infrastructure\Persistence\Eloquent\Repository\BankAccountRepositoryDb;
use Tests\TestCase;

class PaginatePixKeyUseCaseTest extends TestCase
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
        $bank = BankAccountModel::factory()->create();
        PixKeyModel::factory()->count(20)->create([
            'bank_account_id' => $bank->id,
        ]);

        $useCase = new PaginatePixKeyUseCase(bankAccountRepository: $this->bankAccountRepository);
        $result = ($useCase)(input: new PaginatePixKeyInputDto($bank->id));

        $this->assertInstanceOf(PaginationInterface::class, $result);
        $this->assertCount(15, $result->items());
    }
}
