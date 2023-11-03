<?php

namespace Core\Ui\Factories\Controller\PixKey;

use Core\Ui\Api\Controllers\PixKey\ExistPixKeyController;
use Core\Ui\Factories\UseCase\PixKey\ExistPixKeyUseCaseFactory;

class ExistPixKeyControllerFactory
{
    public static function create(): ExistPixKeyController
    {
        return new ExistPixKeyController(existPixKeyUseCase: ExistPixKeyUseCaseFactory::create());
    }
}
