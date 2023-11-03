<?php

namespace Core\Domain\Account\Entity;

use Core\Domain\Account\Factory\AccountValidatorFactory;
use Core\Domain\Bank\Entity\Bank;
use Core\Domain\PixKey\Entity\PixKey;
use Core\Domain\Shared\Entity\Entity;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;

class Account extends Entity
{
    /**
     * @param PixKey[] $pixKeys
     * @throws NotificationException
     */
    public function __construct(
        protected string $ownerName,
        protected string $number,
        protected Bank $bank,
        protected array $pixKeys = [],
        protected ?Uuid $id = null,
        protected ?\DateTime $createdAt = null,
        protected ?\DateTime $updatedAt = null,
    ) {
        parent::__construct();

        $this->addId();
        $this->addCreatedAt();

        $this->validation();
    }

    /**
     * @throws NotificationException
     */
    protected function validation(): void
    {
        AccountValidatorFactory::create()->validate($this);

        if ($this->notification->hasErrors()) {
            throw NotificationException::messages(
                messages: $this->notification->messages('account')
            );
        }
    }

    public function bankId(): string
    {
        return $this->bank->id();
    }

    public function bank(): Bank
    {
        return $this->bank;
    }

    public function pixKeys(): array
    {
        return $this->pixKeys;
    }
    public function addPixKey(PixKey $pixKey): void
    {
        $this->pixKeys[] = $pixKey;
    }

    public function removePixKey(PixKey $pixKey): void
    {
        $this->pixKeys = array_filter($this->pixKeys(), function ($item) use ($pixKey) {
            return $item->id() !== $pixKey->id();
        });
    }
}
