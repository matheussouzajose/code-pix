<?php

namespace Core\Application\UseCase\Transaction\Paginate;

use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Domain\Shared\Repository\PaginationInterface;
use Core\Domain\Transaction\Repository\TransactionRepositoryInterface;

class PaginateTransactionUseCase
{
    public function __construct(
        protected TransactionRepositoryInterface $transactionRepository,
        protected BankAccountRepositoryInterface $bankAccountRepository,
    ) {
    }

    public function __invoke(PaginateTransactionInputDto $input): PaginationInterface
    {
        $this->bankAccountRepository->findById(id: $input->bankAccountId);

        return $this->transactionRepository->paginate(
            bankAccountId: $input->bankAccountId,
            filter: $input->filter,
            order: $input->order,
            page: $input->page,
            totalPage: $input->totalPage
        );
    }
}
