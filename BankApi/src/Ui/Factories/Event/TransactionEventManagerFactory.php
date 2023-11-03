<?php

namespace Core\Ui\Factories\Event;

use Core\Infrastructure\Event\TransactionEventManager;

class TransactionEventManagerFactory
{
    public static function create(): TransactionEventManager
    {
        return new TransactionEventManager();
    }
}
