<?php

namespace Tests\Unit\Application\UseCase\BankAccount;

use Core\Application\UseCase\BankAccount\Paginate\PaginateBankAccountUseCase;
use Core\Application\UseCase\Shared\Dto\PaginateInputDto;
use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Domain\Shared\ObjectValues\Uuid;
use Core\Domain\Shared\Repository\PaginationInterface;
use Tests\TestCase;

class PaginateBankAccountUseCaseUnitTest extends TestCase
{
    public function test_empty_paginate_bank_account()
    {
        $pagination = $this->mockPagination();

        $bankAccountRepository = \Mockery::mock(\stdClass::class, BankAccountRepositoryInterface::class);
        $bankAccountRepository->shouldReceive('paginate')->andReturn($pagination);

        $useCase = new PaginateBankAccountUseCase($bankAccountRepository);
        $result = ($useCase)(input: new PaginateInputDto());

        $this->assertCount(0, $result->items());
        $this->assertInstanceOf(PaginationInterface::class, $result);
    }

    public function test_paginate_bank_account()
    {
        $stdClass = new \stdClass();
        $stdClass->id = Uuid::random();
        $stdClass->number = '1111';
        $stdClass->owner_name = 'Matheus';
        $stdClass->balance = 1000;
        $stdClass->createdAt = 'createdAt';

        $pagination = $this->mockPagination([
            $stdClass,
        ]);

        $bankAccountRepository = \Mockery::mock(\stdClass::class, BankAccountRepositoryInterface::class);
        $bankAccountRepository->shouldReceive('paginate')->andReturn($pagination);

        $useCase = new PaginateBankAccountUseCase($bankAccountRepository);
        $result = ($useCase)(input: new PaginateInputDto());

        $this->assertCount(1, $result->items());
        $this->assertInstanceOf(PaginationInterface::class, $result);
        $this->assertInstanceOf(\stdClass::class, $result->items()[0]);
    }

    protected function mockPagination(array $items = []): PaginationInterface
    {
        $mockPagination = \Mockery::mock(\stdClass::class, PaginationInterface::class);
        $mockPagination->shouldReceive('items')->andReturn($items);
        $mockPagination->shouldReceive('total')->andReturn(0);
        $mockPagination->shouldReceive('currentPage')->andReturn(0);
        $mockPagination->shouldReceive('firstPage')->andReturn(0);
        $mockPagination->shouldReceive('lastPage')->andReturn(0);
        $mockPagination->shouldReceive('perPage')->andReturn(0);
        $mockPagination->shouldReceive('to')->andReturn(0);
        $mockPagination->shouldReceive('from')->andReturn(0);

        return $mockPagination;
    }
}
