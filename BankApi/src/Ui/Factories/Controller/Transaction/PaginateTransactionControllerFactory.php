<?php

namespace Core\Ui\Factories\Controller\Transaction;

use Core\Ui\Api\Controllers\Transaction\PaginateTransactionController;
use Core\Ui\Factories\UseCase\Transaction\PaginateTransactionUseCaseFactory;

class PaginateTransactionControllerFactory
{
    public static function create(): PaginateTransactionController
    {
        $useCase = PaginateTransactionUseCaseFactory::create();
        return new PaginateTransactionController(paginateTransactionUseCase: $useCase);
    }
}
