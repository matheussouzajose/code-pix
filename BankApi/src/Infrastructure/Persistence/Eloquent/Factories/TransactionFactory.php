<?php

namespace Core\Infrastructure\Persistence\Eloquent\Factories;

use App\Models\Transaction as TransactionModel;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;
use Core\Domain\Transaction\Entity\Transaction;
use Core\Domain\Transaction\Enum\TransactionOperation;
use Core\Domain\Transaction\Enum\TransactionStatus;

class TransactionFactory
{
    /**
     * @throws NotificationException
     */
    public static function create(TransactionModel $model): Transaction
    {
        return new Transaction(
            amount: $model->amount,
            description: $model->description,
            bankAccountFromId: new Uuid($model->bank_account_from_id),
            pixKeyTo: $model->pix_key_key,
            pixKindTo: $model->pix_key_kind,
            status: TransactionStatus::tryFrom($model->status),
            operation: TransactionOperation::tryFrom($model->operation),
            externalId: new Uuid($model->external_id),
            id: new Uuid($model->id),
            createdAt: $model->created_at,
            updatedAt: $model->updated_at
        );
    }
}
