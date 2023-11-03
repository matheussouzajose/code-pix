<?php

namespace Core\Ui\Api\Controllers\PixKey;

use App\Exceptions\ServerErrorRequestHttpException;
use Core\Application\UseCase\PixKey\Exist\ExistPixKeyInputDto;
use Core\Application\UseCase\PixKey\Exist\ExistPixKeyOutputDto;
use Core\Application\UseCase\PixKey\Exist\ExistPixKeyUseCase;

class ExistPixKeyController
{
    public function __construct(protected ExistPixKeyUseCase $existPixKeyUseCase)
    {
    }

    /**
     * @throws ServerErrorRequestHttpException
     */
    public function __invoke(string $bankAccountId, string $kind, string $key): ExistPixKeyOutputDto
    {
        return ($this->existPixKeyUseCase)(
            input: $this->createFromRequest(bankAccountId: $bankAccountId, kind: $kind, key: $key)
        );
    }

    private function createFromRequest(string $bankAccountId, string $kind, string $key): ExistPixKeyInputDto
    {
        return new ExistPixKeyInputDto(bankAccountId: $bankAccountId, kind: $kind, key: $key);
    }
}
