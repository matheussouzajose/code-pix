<?php

namespace Core\Domain\Shared\Event;

interface EventInterface
{
    public function getEventName(): string;

    public function getPayload(): array;
}
