<?php

namespace Core\Domain\Shared\Event;

interface EventManagerInterface
{
    public function dispatch(object $event): void;
}
