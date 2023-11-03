<?php

namespace Core\Application\UseCase\PixKey\Find;

class FindKeyInputDto
{
    public function __construct(public string $key, public string $kind)
    {
    }
}
