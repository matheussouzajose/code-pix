<?php

namespace Core\Application\UseCase\PixKey\Create;

class CreatePixKeyOutputDto
{
    public function __construct(
        public string $id,
        public string $status,
        public ?string $error = null,
    ) {
    }
}
