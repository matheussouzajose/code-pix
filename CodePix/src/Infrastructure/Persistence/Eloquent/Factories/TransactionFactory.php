<?php

namespace Core\Infrastructure\Persistence\Eloquent\Factories;

use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;
use Core\Domain\Transaction\Entity\Transaction;
use Core\Domain\Transaction\Enum\StatusTransactionType;

class TransactionFactory
{
    /**
     * @throws NotificationException
     */
    public static function create(object $data): Transaction
    {
        $accountFrom = AccountFactory::create(data: $data->account);
        $pixKeyTo = PixKeyFactory::create(data: $data->pixKey);

        return new Transaction(
            accountFrom: $accountFrom,
            amount: $data->amount,
            pixKeyTo: $pixKeyTo,
            description: $data->description,
            cancelDescription: $data->cancelDescription,
            id: new Uuid($data->id),
            createdAt: $data->created_at,
            updatedAt: $data->updated_at,
            status: StatusTransactionType::tryFrom($data->status)
        );
    }
}
