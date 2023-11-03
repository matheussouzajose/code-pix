<?php

namespace Core\Domain\BankAccount\Repository;

use Core\Domain\BankAccount\Entity\BankAccount;
use Core\Domain\Shared\Repository\PaginationInterface;

interface BankAccountRepositoryInterface
{
    public function findById(string $id): BankAccount;

    public function paginate(
        string $filter = '',
        string $order = 'DESC',
        int $page = 1,
        int $totalPage = 15
    ): PaginationInterface;

    public function save(BankAccount $bankAccount): BankAccount;
}
