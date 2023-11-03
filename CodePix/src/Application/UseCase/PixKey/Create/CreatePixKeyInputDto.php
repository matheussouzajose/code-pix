<?php

namespace Core\Application\UseCase\PixKey\Create;

class CreatePixKeyInputDto
{
    public function __construct(
        public string $accountId,
        public string $key,
        public string $kind,
    ) {
    }
}
