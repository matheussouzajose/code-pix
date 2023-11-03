<?php

namespace Core\Infrastructure\Messaging\Kafka\Factory;

use Core\Infrastructure\Messaging\Kafka\ProcessMessageInterface;
use Core\Infrastructure\Messaging\Kafka\Transaction\ProcessTransaction;
use Core\Ui\Factories\UseCase\Transaction\SaveTransactionUseCaseFactory;

class ProcessMessagesFactory
{
    public static function create(string $topic): ?ProcessMessageInterface
    {
        return match ($topic) {
            'bank001' => new ProcessTransaction(
                saveTransactionUseCase: SaveTransactionUseCaseFactory::create()
            ),
            default => null,
        };
    }
}
