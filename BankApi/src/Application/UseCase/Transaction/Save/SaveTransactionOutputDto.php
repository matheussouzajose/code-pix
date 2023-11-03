<?php

namespace Core\Application\UseCase\Transaction\Save;

class SaveTransactionOutputDto
{
    public function __construct(
        public string $id,
        public string $externalId,
        public string $status,
        public ?string $updatedAt = null,
    ) {
    }
}
