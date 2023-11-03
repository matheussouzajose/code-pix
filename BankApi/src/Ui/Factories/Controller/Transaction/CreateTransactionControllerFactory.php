<?php

namespace Core\Ui\Factories\Controller\Transaction;

use Core\Ui\Api\Controllers\Transaction\CreateTransactionController;
use Core\Ui\Factories\UseCase\Transaction\CreateTransactionUseCaseFactory;

class CreateTransactionControllerFactory
{
    public static function create(): CreateTransactionController
    {
        return new CreateTransactionController(createTransactionUseCase: CreateTransactionUseCaseFactory::create());
    }
}
