<?php

namespace Core\Infrastructure\Persistence\Eloquent\Factories;

use Core\Domain\PixKey\Entity\PixKey;
use Core\Domain\PixKey\Enum\KindType;
use Core\Domain\PixKey\Enum\StatusType;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;

class PixKeyFactory
{
    /**
     * @throws NotificationException
     */
    public static function create(object $data): PixKey
    {
        $account = AccountFactory::create(data: $data->account);

        return new PixKey(
            kind: KindType::tryFrom($data->kind),
            key: $data->key,
            account: $account,
            status: StatusType::tryFrom($data->status),
            id: new Uuid($data->id),
            createdAt: $data->created_at,
            updatedAt: $data->updated_at,
        );
    }

    /**
     * @throws NotificationException
     */
    public static function createWithTransactions(object $data): PixKey
    {
        $account = AccountFactory::create(data: $data->account);

        $pixKey = new PixKey(
            kind: KindType::tryFrom($data->kind),
            key: $data->key,
            account: $account,
            status: StatusType::tryFrom($data->status),
            id: new Uuid($data->id),
            createdAt: $data->created_at,
            updatedAt: $data->updated_at,
        );

        foreach ($data->transactions as $transaction) {
            $pixKey->addTransaction(TransactionFactory::create(data: $transaction));
        }

        return $pixKey;
    }
}
