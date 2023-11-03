<?php

namespace Core\Application\UseCase\Transaction\Status;

class SaveTransactionOutputDto
{
    public function __construct(
        public string $id,
        public string $accountId,
        public string $pixKeyId,
        public float $amount,
        public string $status,
        public string $description,
        public string $createdAt,
        public object $accountFrom,
    ) {
    }
}
