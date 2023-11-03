<?php

namespace Core\Application\UseCase\PixKey\Exist;

class ExistPixKeyInputDto
{
    public function __construct(
        public string $bankAccountId,
        public string $kind,
        public string $key
    ) {
    }
}
