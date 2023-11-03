<?php

namespace Core\Application\UseCase\PixKey\Exist;

class ExistPixKeyOutputDto
{
    public function __construct(public bool $exist)
    {
    }
}
