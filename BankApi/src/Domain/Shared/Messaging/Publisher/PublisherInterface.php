<?php

namespace Core\Domain\Shared\Messaging\Publisher;

interface PublisherInterface
{
    public function publish(string $topic, string $message): void;
}
