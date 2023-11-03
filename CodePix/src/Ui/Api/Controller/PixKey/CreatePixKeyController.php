<?php

namespace Core\Ui\Api\Controller\PixKey;

use Core\Application\UseCase\PixKey\Create\CreatePixKeyInputDto;
use Core\Application\UseCase\PixKey\Create\CreatePixKeyOutputDto;
use Core\Application\UseCase\PixKey\Create\CreatePixKeyUseCase;
use Core\Domain\Shared\Exception\NotificationException;

class CreatePixKeyController
{
    public function __construct(protected CreatePixKeyUseCase $useCase)
    {
    }

    /**
     * @throws NotificationException
     */
    public function __invoke(object $request): CreatePixKeyOutputDto
    {
        return ($this->useCase)($this->createFromRequest(request: $request));
    }

    private function createFromRequest(object $request): CreatePixKeyInputDto
    {
        return new CreatePixKeyInputDto(
            accountId: $request->account_id,
            key: $request->key,
            kind: $request->kind,
        );
    }
}
