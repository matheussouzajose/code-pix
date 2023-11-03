<?php

namespace Core\Domain\Transaction\Repository;

use Core\Domain\Shared\Repository\PaginationInterface;
use Core\Domain\Transaction\Entity\Transaction;

interface TransactionRepositoryInterface
{
    public function findByExternalId(string $externalId): Transaction;

    public function create(Transaction $data): Transaction;

    public function save(Transaction $transaction): Transaction;

    public function paginate(
        string $bankAccountId,
        string $filter = '',
        string $order = 'DESC',
        int $page = 1,
        int $totalPage = 15
    ): PaginationInterface;

}
