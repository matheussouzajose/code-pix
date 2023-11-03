<?php

namespace Core\Ui\Api\Controllers\PixKey;

use Core\Application\UseCase\PixKey\Create\CreatePixKeyInputDto;
use Core\Application\UseCase\PixKey\Create\CreatePixKeyOutputDto;
use Core\Application\UseCase\PixKey\Create\CreatePixKeyUseCase;
use Core\Domain\Shared\Exception\NotificationException;

class CreatePixKeyController
{
    public function __construct(protected CreatePixKeyUseCase $createPixKeyUseCase)
    {
    }

    /**
     * @throws NotificationException
     * @throws \Throwable
     */
    public function __invoke(string $bankAccountId, object $request): CreatePixKeyOutputDto
    {
        return ($this->createPixKeyUseCase)(
            input: $this->createFromRequest(bankAccountId: $bankAccountId, request: $request)
        );
    }

    private function createFromRequest(string $bankAccountId, object $request): CreatePixKeyInputDto
    {
        return new CreatePixKeyInputDto(
            bankAccountId: $bankAccountId,
            kind: $request->kind,
            key: $request->key
        );
    }
}
