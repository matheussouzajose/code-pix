<?php

namespace Core\Application\UseCase\PixKey\Create;

class CreatePixKeyInputDto
{
    public function __construct(
        public string $bankAccountId,
        public string $kind,
        public string $key
    ) {
    }
}
