<?php

namespace Tests\Unit\Application\UseCase\PixKey;

use Core\Application\UseCase\PixKey\Paginate\PaginatePixKeyInputDto;
use Core\Application\UseCase\PixKey\Paginate\PaginatePixKeyUseCase;
use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Domain\Shared\ObjectValues\Uuid;
use Core\Domain\Shared\Repository\PaginationInterface;
use Tests\TestCase;

class PaginatePixKeyUseCaseUnitTest extends TestCase
{
    public function test_empty_paginate_pix_key()
    {
        $pagination = $this->mockPagination();

        $bankAccountRepository = \Mockery::mock(\stdClass::class, BankAccountRepositoryInterface::class);
        $bankAccountRepository->shouldReceive('paginatePixKey')->andReturn($pagination);

        $useCase = new PaginatePixKeyUseCase($bankAccountRepository);
        $result = ($useCase)(input: new PaginatePixKeyInputDto('uuid'));

        $this->assertCount(0, $result->items());
        $this->assertInstanceOf(PaginationInterface::class, $result);
    }

    public function test_paginate_pix_key()
    {
        $bankAccount = new \stdClass();
        $bankAccount->id = Uuid::random();
        $bankAccount->number = '1111';
        $bankAccount->owner_name = 'Matheus';
        $bankAccount->balance = 1000;
        $bankAccount->createdAt = 'createdAt';

        $stdClass = new \stdClass();
        $stdClass->id = Uuid::random();
        $stdClass->kind = Uuid::random();
        $stdClass->key = Uuid::random();
        $stdClass->bankAccount = $bankAccount;
        $bankAccount->createdAt = 'createdAt';

        $pagination = $this->mockPagination([
            $stdClass,
        ]);

        $bankAccountRepository = \Mockery::mock(\stdClass::class, BankAccountRepositoryInterface::class);
        $bankAccountRepository->shouldReceive('paginatePixKey')->andReturn($pagination);

        $useCase = new PaginatePixKeyUseCase($bankAccountRepository);
        $result = ($useCase)(input: new PaginatePixKeyInputDto('uuid'));

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
