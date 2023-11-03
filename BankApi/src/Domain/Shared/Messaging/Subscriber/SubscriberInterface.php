<?php

namespace Core\Domain\Shared\Messaging\Subscriber;

interface SubscriberInterface
{
    public function subscribe(array $topics): void;
}
