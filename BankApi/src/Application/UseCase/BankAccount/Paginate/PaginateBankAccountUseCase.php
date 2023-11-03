<?php

namespace Core\Application\UseCase\BankAccount\Paginate;

use Core\Application\UseCase\Shared\Dto\PaginateInputDto;
use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Domain\Shared\Repository\PaginationInterface;

class PaginateBankAccountUseCase
{
    public function __construct(protected BankAccountRepositoryInterface $bankAccountRepository)
    {
    }

    public function __invoke(PaginateInputDto $input): PaginationInterface
    {
        return $this->bankAccountRepository->paginate(
            filter: $input->filter,
            order: $input->order,
            page: $input->page,
            totalPage: $input->totalPage
        );
    }
}
