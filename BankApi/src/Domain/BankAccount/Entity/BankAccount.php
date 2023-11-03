<?php

namespace Core\Domain\BankAccount\Entity;

use Core\Domain\BankAccount\Factory\BankAccountValidatorFactory;
use Core\Domain\BankAccount\Validator\BankAccountValidator;
use Core\Domain\Shared\Entity\Entity;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;

class BankAccount extends Entity
{
    /**
     * @throws NotificationException
     */
    public function __construct(
        protected string $number,
        protected string $ownerName,
        protected float $balance = 0.0,
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
    public function validation(): void
    {
        BankAccountValidatorFactory::create()->validate($this);

        if ($this->notification->hasErrors()) {
            throw NotificationException::messages(
                messages: $this->notification->messages(BankAccountValidator::CONTEXT)
            );
        }
    }

    public function creditBalance(float $balance): void
    {
        $this->balance += $balance;
    }

    public function debitBalance(float $balance): void
    {
        $this->balance -= $balance;
    }

    public function addPixKey(string $pixKeyId): void
    {
        $this->pixKeys[] = $pixKeyId;
    }

    public function removePixKey(string $pixKeyId): void
    {
        unset($this->pixKeys[array_search($pixKeyId, $this->pixKeys)]);
    }
}
