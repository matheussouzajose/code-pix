<?php

namespace Core\Infrastructure\Persistence\Eloquent\Factories;

use Core\Domain\Account\Entity\Account;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;

class AccountFactory
{
    /**
     * @throws NotificationException
     */
    public static function create(object $data): Account
    {
        $bank = BankFactory::create($data->bank);

        return new Account(
            ownerName: $data->owner_name,
            number: $data->number,
            bank: $bank,
            id: new Uuid($data->id),
            createdAt: $data->created_at,
            updatedAt: $data->updated_at,
        );
    }

    /**
     * @throws NotificationException
     */
    public static function createWithPixKeys(object $data): Account
    {
        $bank = BankFactory::create($data->bank);

        $account = new Account(
            ownerName: $data->owner_name,
            number: $data->number,
            bank: $bank,
            id: new Uuid($data->id),
            createdAt: $data->created_at,
            updatedAt: $data->updated_at,
        );

        foreach ($data->pixKeys as $pixKey) {
            $account->addPixKey(
                pixKey: PixKeyFactory::create(data: $pixKey)
            );
        }

        return $account;
    }
}
