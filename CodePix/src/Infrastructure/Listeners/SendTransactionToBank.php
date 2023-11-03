<?php

namespace Core\Infrastructure\Listeners;

use Core\Domain\Shared\Messaging\Publisher\PublisherInterface;

class SendTransactionToBank
{
    public function __construct(protected PublisherInterface $publisher)
    {
    }

    public function handle(object $event): void
    {
        $this->publisher->publish(
            topic: $event->getTopic(),
            message: json_encode($event->getPayload())
        );
    }
}
