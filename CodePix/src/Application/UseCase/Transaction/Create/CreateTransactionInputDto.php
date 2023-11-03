<?php

namespace Core\Application\UseCase\Transaction\Create;

class CreateTransactionInputDto
{
    public function __construct(
        public string $externalId,
        public string $accountId,
        public float $amount,
        public string $pixKeyTo,
        public string $pixKeyKindTo,
        public string $description,
    ) {
    }

}
