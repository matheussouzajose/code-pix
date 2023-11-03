<?php

namespace Core\Infrastructure\Event;

use Core\Domain\Shared\Event\EventManagerInterface;

class TransactionEventManager implements EventManagerInterface
{
    public function dispatch(object $event): void
    {
        event($event);
    }
}
