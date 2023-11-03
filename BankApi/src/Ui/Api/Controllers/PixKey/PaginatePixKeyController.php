<?php

namespace Core\Ui\Api\Controllers\PixKey;

use Core\Application\UseCase\PixKey\Paginate\PaginatePixKeyInputDto;
use Core\Application\UseCase\PixKey\Paginate\PaginatePixKeyUseCase;
use Core\Domain\Shared\Repository\PaginationInterface;

class PaginatePixKeyController
{
    public function __construct(protected PaginatePixKeyUseCase $paginatePixKeyUseCase)
    {
    }

    public function __invoke(string $bankAccountId, object $request): PaginationInterface
    {
        return ($this->paginatePixKeyUseCase)(
            input: $this->createFromRequest(bankAccountId: $bankAccountId, request: $request)
        );
    }

    private function createFromRequest(string $bankAccountId, object $request): PaginatePixKeyInputDto
    {
        return new PaginatePixKeyInputDto(
            bankAccountId: $bankAccountId,
            filter: (string) $request->get('filter', ''),
            order: (string) $request->get('order', 'DESC'),
            page: (int) $request->get('page', 1),
            totalPage: (int) $request->get('total_page', 15),
        );
    }
}
