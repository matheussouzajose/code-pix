<?php

namespace Core\Ui\Factories\UseCase\PixKey;

use Core\Application\UseCase\PixKey\Create\CreatePixKeyUseCase;
use Core\Ui\Factories\Repository\PixKeyRepositoryFactory;

class CreatePixKeyUseCaseFactory
{
    public static function create(): CreatePixKeyUseCase
    {
        return new CreatePixKeyUseCase(
            pixKeyRepository: PixKeyRepositoryFactory::create()
        );
    }
}
