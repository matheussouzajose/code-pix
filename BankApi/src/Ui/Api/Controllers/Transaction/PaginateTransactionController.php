<?php

namespace Core\Ui\Api\Controllers\Transaction;

use Core\Application\UseCase\Transaction\Paginate\PaginateTransactionInputDto;
use Core\Application\UseCase\Transaction\Paginate\PaginateTransactionUseCase;
use Core\Domain\Shared\Repository\PaginationInterface;

class PaginateTransactionController
{
    public function __construct(protected PaginateTransactionUseCase $paginateTransactionUseCase)
    {
    }

    public function __invoke(string $bankAccountId, object $request): PaginationInterface
    {
        return ($this->paginateTransactionUseCase)(
            input: $this->createFromRequest(bankAccountId: $bankAccountId, request: $request)
        );
    }

    private function createFromRequest(string $bankAccountId, object $request): PaginateTransactionInputDto
    {
        return new PaginateTransactionInputDto(
            bankAccountId: $bankAccountId,
            filter: (string) $request->get('filter', ''),
            order: (string) $request->get('order', 'DESC'),
            page: (int) $request->get('page', 1),
            totalPage: (int) $request->get('total_page', 15),
        );
    }
}
