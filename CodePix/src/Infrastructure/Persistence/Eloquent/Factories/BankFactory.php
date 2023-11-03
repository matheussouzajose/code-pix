<?php

namespace Core\Infrastructure\Persistence\Eloquent\Factories;

use Core\Domain\Bank\Entity\Bank;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;

class BankFactory
{
    /**
     * @throws NotificationException
     */
    public static function create(object $data): Bank
    {
        return new Bank(
            code: $data->code,
            name: $data->name,
            id: new Uuid($data->id),
            createdAt: $data->created_at,
            updatedAt: $data->updated_at
        );
    }

    /**
     * @throws NotificationException
     */
    public static function createWithAccounts(object $data): Bank
    {
        $bank = self::create($data);

        foreach ($data->accounts as $account) {
            $bank->addAccount($account);
        }

        return $bank;
    }
}
