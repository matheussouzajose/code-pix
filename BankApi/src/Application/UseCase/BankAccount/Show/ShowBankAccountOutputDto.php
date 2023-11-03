<?php

namespace Core\Application\UseCase\BankAccount\Show;

class ShowBankAccountOutputDto
{
    public function __construct(
        public string $id,
        public string $number,
        public string $ownerName,
        public float $balance,
        public string $createdAt,
    ) {
    }
}
