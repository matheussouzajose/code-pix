<?php

namespace Core\Domain\Shared\Repository;

interface TransactionInterface
{
    public function commit(): void;

    public function rollback(): void;
}
