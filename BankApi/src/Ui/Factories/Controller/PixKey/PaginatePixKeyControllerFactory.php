<?php

namespace Core\Ui\Factories\Controller\PixKey;

use Core\Ui\Api\Controllers\PixKey\PaginatePixKeyController;
use Core\Ui\Factories\UseCase\PixKey\PaginatePixKeyUseCaseFactory;

class PaginatePixKeyControllerFactory
{
    public static function create(): PaginatePixKeyController
    {
        $useCase = PaginatePixKeyUseCaseFactory::create();
        return new PaginatePixKeyController(paginatePixKeyUseCase: $useCase);
    }
}
