<?php

namespace Core\Infrastructure\Messaging\Kafka\Factory;


use Core\Application\UseCase\Transaction\Status\SaveTransactionUseCase;
use Core\Infrastructure\Messaging\Kafka\ProcessMessageInterface;
use Core\Infrastructure\Messaging\Kafka\Transaction\ProcessSaveTransaction;
use Core\Infrastructure\Messaging\Kafka\Transaction\ProcessTransaction;
use Core\Ui\Factories\UseCase\CreateTransactionUseCaseFactory;
use Core\Ui\Factories\UseCase\SaveTransactionUseCaseFactory;

class ProcessMessagesFactory
{
    public static function create(string $topic): ?ProcessMessageInterface
    {
        return match ($topic) {
            'transactions' => new ProcessTransaction(
                createTransactionUseCase: CreateTransactionUseCaseFactory::create()
            ),
            'transaction_confirmation' => new ProcessSaveTransaction(
                saveTransactionUseCase: SaveTransactionUseCaseFactory::create()
            ),
            default => null,
        };
    }
}
