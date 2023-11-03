<?php

namespace Core\Application\UseCase\Transaction\Status;

class SaveTransactionInputDto
{
    public function __construct(
        public string $externalId,
        public string $status
    ) {
    }
}
