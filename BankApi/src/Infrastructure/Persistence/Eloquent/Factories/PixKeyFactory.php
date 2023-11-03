<?php

namespace Core\Infrastructure\Persistence\Eloquent\Factories;

use App\Models\PixKey as PixKeyModel;
use Core\Domain\PixKey\Entity\PixKey;
use Core\Domain\PixKey\Enum\PixKeyKind;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;

class PixKeyFactory
{
    /**
     * @throws NotificationException
     */
    public static function create(PixKeyModel $model): PixKey
    {
        return new PixKey(
            key: $model->key,
            kind: PixKeyKind::tryFrom($model->kind),
            bankAccount: BankAccountFactory::create(model: $model->bankAccount),
            id: new Uuid($model->id),
            createdAt: $model->created_at,
            updatedAt: $model->updated_at
        );
    }
}
