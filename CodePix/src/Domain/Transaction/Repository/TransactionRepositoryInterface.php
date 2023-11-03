<?php

namespace Core\Domain\Transaction\Repository;

use Core\Domain\Transaction\Entity\Transaction;

interface TransactionRepositoryInterface
{
    public function register(Transaction $transaction): Transaction;

    public function save(Transaction $transaction): Transaction;

    public function findById(string $id): Transaction;
}
