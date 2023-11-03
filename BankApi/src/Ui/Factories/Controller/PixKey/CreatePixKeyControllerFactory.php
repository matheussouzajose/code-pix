<?php

namespace Core\Ui\Factories\Controller\PixKey;

use Core\Ui\Api\Controllers\PixKey\CreatePixKeyController;
use Core\Ui\Factories\UseCase\PixKey\CreatePixKeyUseCaseFactory;

class CreatePixKeyControllerFactory
{
    public static function create(): CreatePixKeyController
    {
        return new CreatePixKeyController(
            createPixKeyUseCase: CreatePixKeyUseCaseFactory::create()
        );
    }
}
