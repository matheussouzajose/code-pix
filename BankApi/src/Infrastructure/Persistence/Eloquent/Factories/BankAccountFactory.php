<?php

namespace Core\Infrastructure\Persistence\Eloquent\Factories;

use App\Models\BankAccount as BankAccountModel;
use Core\Domain\BankAccount\Entity\BankAccount;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;

class BankAccountFactory
{
    /**
     * @throws NotificationException
     */
    public static function create(BankAccountModel $model): BankAccount
    {
        $bankAccount = new BankAccount(
            number: $model->number,
            ownerName: $model->owner_name,
            balance: $model->balance,
            id: new Uuid($model->id),
            createdAt: $model->created_at,
            updatedAt: $model->updated_at
        );

        foreach ($model->pixKeys as $pixKey) {
            $bankAccount->addPixKey($pixKey->key);
        }

        return $bankAccount;
    }
}
