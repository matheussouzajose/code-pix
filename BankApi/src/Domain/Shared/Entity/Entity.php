<?php

namespace Core\Domain\Shared\Entity;

use Core\Domain\Shared\Exception\PropertyClassException;
use Core\Domain\Shared\Notification\Notification;
use Core\Domain\Shared\ObjectValues\Uuid;

abstract class Entity
{
    protected Notification $notification;

    public function __construct()
    {
        $this->notification = new Notification();
    }

    public function __get($property)
    {
        if (isset($this->{$property})) {
            return $this->{$property};
        }

        $className = get_class($this);
        throw PropertyClassException::propertyNotFound($property, $className);
    }

    public function id(): string
    {
        return (string) $this->id;
    }

    public function createdAt(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }

    public function updatedAt(): ?string
    {
        if (isset($this->updatedAt)) {
            return $this->updatedAt->format('Y-m-d H:i:s');
        }

        return null;
    }

    protected function addId(): void
    {
        $this->id = $this->id ?? Uuid::random();
    }

    protected function addCreatedAt(): void
    {
        $this->createdAt = $this->createdAt ?? new \DateTime();
    }
}
