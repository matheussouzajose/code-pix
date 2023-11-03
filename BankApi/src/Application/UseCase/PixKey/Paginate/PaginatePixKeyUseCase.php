<?php

namespace Core\Application\UseCase\PixKey\Paginate;

use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Domain\PixKey\Repository\PixKeyInterfaceRepository;
use Core\Domain\Shared\Repository\PaginationInterface;

class PaginatePixKeyUseCase
{
    public function __construct(
        protected PixKeyInterfaceRepository $pixKeyInterfaceRepository,
        protected BankAccountRepositoryInterface $bankAccountRepository
    ) {
    }

    public function __invoke(PaginatePixKeyInputDto $input): PaginationInterface
    {
        $this->bankAccountRepository->findById(id: $input->bankAccountId);

        return $this->pixKeyInterfaceRepository->paginate(
            bankAccountId: $input->bankAccountId,
            filter: $input->filter,
            order: $input->order,
            page: $input->page,
            totalPage: $input->totalPage
        );
    }
}
