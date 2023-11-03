<?php

namespace Core\Application\UseCase\PixKey\Create;

class CreatePixKeyOutputDto
{
    public function __construct(
        public string $id,
        public string $kind,
        public string $key,
        public object $bankAccount,
        public string $createdAt,
    ) {
    }
}
