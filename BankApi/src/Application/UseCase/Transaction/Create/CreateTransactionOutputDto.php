<?php

namespace Core\Application\UseCase\Transaction\Create;

class CreateTransactionOutputDto
{
    public function __construct(
        public string $id,
        public string $externalId,
        public string $bankAccountFromId,
        public string $pixKeyTo,
        public string $pixKindTo,
        public string $amount,
        public string $description,
        public string $status,
        public string $operation,
        public string $createdAt,
    ) {
    }
}
