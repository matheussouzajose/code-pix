<?php

namespace Core\Ui\Api\Controller\PixKey;

use Core\Application\UseCase\PixKey\Find\FindKeyInputDto;
use Core\Application\UseCase\PixKey\Find\FindKeyOutputDto;
use Core\Application\UseCase\PixKey\Find\FindKeyUseCase;

class FindPixKeyController
{
    public function __construct(protected FindKeyUseCase $useCase)
    {
    }

    public function __invoke(object $request): FindKeyOutputDto
    {
        return ($this->useCase)($this->createFromRequest(request: $request));
    }

    private function createFromRequest(object $request): FindKeyInputDto
    {
        return new FindKeyInputDto(
            key: $request->key,
            kind: $request->kind,
        );
    }
}
