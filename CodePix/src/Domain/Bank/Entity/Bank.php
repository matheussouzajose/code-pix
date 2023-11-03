<?php

namespace Core\Domain\Bank\Entity;

use Core\Domain\Account\Entity\Account;
use Core\Domain\Bank\Factory\BankValidatorFactory;
use Core\Domain\Shared\Entity\Entity;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;

class Bank extends Entity
{
    /**
     * @param Account[] $accounts
     * @throws NotificationException
     */
    public function __construct(
        protected string $code,
        protected string $name,
        protected array $accounts = [],
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
        BankValidatorFactory::create()->validate($this);

        if ($this->notification->hasErrors()) {
            throw NotificationException::messages(
                messages: $this->notification->messages('bank')
            );
        }
    }

    public function accounts(): array
    {
        return $this->accounts;
    }
    public function addAccount(Account $account): void
    {
        $this->accounts[] = $account;
    }

    public function removeAccount(Account $account): void
    {
        $this->accounts = array_filter($this->accounts(), function ($item) use ($account) {
            return $item->id() !== $account->id();
        });
    }
}
