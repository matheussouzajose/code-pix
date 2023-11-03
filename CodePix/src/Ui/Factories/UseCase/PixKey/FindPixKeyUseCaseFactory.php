<?php

namespace Core\Ui\Factories\UseCase\PixKey;

use Core\Application\UseCase\PixKey\Find\FindKeyUseCase;
use Core\Ui\Factories\Repository\PixKeyRepositoryFactory;

class FindPixKeyUseCaseFactory
{
    public static function create(): FindKeyUseCase
    {
        return new FindKeyUseCase(
            pixKeyRepository: PixKeyRepositoryFactory::create()
        );
    }
}
