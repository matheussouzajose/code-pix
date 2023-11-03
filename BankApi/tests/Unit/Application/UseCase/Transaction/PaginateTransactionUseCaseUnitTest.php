<?php

namespace Tests\Unit\Application\UseCase\Transaction;

use Core\Application\UseCase\Transaction\Paginate\PaginateTransactionInputDto;
use Core\Application\UseCase\Transaction\Paginate\PaginateTransactionUseCase;
use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Domain\Shared\ObjectValues\Uuid;
use Core\Domain\Shared\Repository\PaginationInterface;
use Tests\Mocks\PaginationMock;
use Tests\TestCase;

class PaginateTransactionUseCaseUnitTest extends TestCase
{
    public function test_empty_paginate_transaction()
    {
        $bankAccountRepository = \Mockery::mock(\stdClass::class, BankAccountRepositoryInterface::class);
        $bankAccountRepository->shouldReceive('paginateTransaction')->andReturn(PaginationMock::mock());

        $useCase = new PaginateTransactionUseCase($bankAccountRepository);
        $result = ($useCase)(input: new PaginateTransactionInputDto('uuid'));

        $this->assertCount(0, $result->items());
        $this->assertInstanceOf(PaginationInterface::class, $result);
    }

    public function test_paginate_bank_account()
    {
        $stdClass = new \stdClass();

        $stdClass->id = Uuid::random();
        $pagination = PaginationMock::mock([$stdClass]);

        $bankAccountRepository = \Mockery::mock(\stdClass::class, BankAccountRepositoryInterface::class);
        $bankAccountRepository->shouldReceive('paginateTransaction')->andReturn($pagination);

        $useCase = new PaginateTransactionUseCase($bankAccountRepository);
        $result = ($useCase)(input: new PaginateTransactionInputDto('uuid'));

        $this->assertCount(1, $result->items());
        $this->assertInstanceOf(PaginationInterface::class, $result);
        $this->assertInstanceOf(\stdClass::class, $result->items()[0]);
    }
}
