<?php

namespace Core\Application\UseCase\PixKey\Find;

use Core\Domain\Account\Entity\Account;

class FindKeyOutputDto
{
    public function __construct(
        public string $id,
        public Account $account,
        public string $kind,
        public string $key,
        public string $status,
        public string $createdAt,
    ) {
    }
}
