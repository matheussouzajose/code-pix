<?php

namespace Core\Application\UseCase\Transaction\Create;

class CreateTransactionInputDto
{
    public function __construct(
        public string $bankAccountFromId,
        public string $pixKeyTo,
        public string $pixKindTo,
        public float $amount,
        public string $description,
    ) {
    }
}
