<?php

namespace Core\Application\UseCase\Transaction\Save;

class SaveTransactionInputDto
{
    public function __construct(
        public string $externalId,
        public string $accountId,
        public float $amount,
        public string $pixKeyTo,
        public string $pixKindTo,
        public string $description,
        public string $status
    ) {
    }
}
