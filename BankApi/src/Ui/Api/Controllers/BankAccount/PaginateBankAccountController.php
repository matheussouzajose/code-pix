<?php

namespace Core\Ui\Api\Controllers\BankAccount;

use Core\Application\UseCase\BankAccount\Paginate\PaginateBankAccountUseCase;
use Core\Application\UseCase\Shared\Dto\PaginateInputDto;
use Core\Domain\Shared\Repository\PaginationInterface;

class PaginateBankAccountController
{
    public function __construct(protected PaginateBankAccountUseCase $paginateBankAccountUseCase)
    {
    }

    public function __invoke(object $request): PaginationInterface
    {
        return ($this->paginateBankAccountUseCase)(
            input: $this->createFromRequest(request: $request)
        );
    }

    private function createFromRequest(object $request): PaginateInputDto
    {
        return new PaginateInputDto(
            filter: (string) $request->get('filter', ''),
            order: (string) $request->get('order', 'DESC'),
            page: (int) $request->get('page', 1),
            totalPage: (int) $request->get('total_page', 15),
        );
    }
}
