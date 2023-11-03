<?php

namespace Core\Infrastructure\Persistence\Eloquent\Transaction;

use Core\Domain\Shared\Repository\TransactionInterface;
use Illuminate\Support\Facades\DB;

class TransactionDb implements TransactionInterface
{
    public function __construct()
    {
        DB::beginTransaction();
    }

    public function commit(): void
    {
        DB::commit();
    }

    public function rollback(): void
    {
        DB::rollBack();
    }
}
