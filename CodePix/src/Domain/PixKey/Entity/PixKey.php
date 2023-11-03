<?php

namespace Core\Domain\PixKey\Entity;

use Core\Domain\Account\Entity\Account;

use Core\Domain\PixKey\Enum\KindType;
use Core\Domain\PixKey\Enum\StatusType;
use Core\Domain\PixKey\Factory\PixKeyValidatorFactory;
use Core\Domain\Shared\Entity\Entity;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;
use Core\Domain\Transaction\Entity\Transaction;

class PixKey extends Entity
{
    /**
     * @throws NotificationException
     */
    public function __construct(
        protected KindType $kind,
        protected string $key,
        protected Account $account,
        protected ?StatusType $status = StatusType::Active,
        protected array $transactions = [],
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
        PixKeyValidatorFactory::create()->validate($this);

        if ($this->notification->hasErrors()) {
            throw NotificationException::messages(
                messages: $this->notification->messages('pix_key')
            );
        }
    }

    public function accountId(): string
    {
        return $this->account->id();
    }

    public function account(): Account
    {
        return $this->account;
    }

    public function transactions(): array
    {
        return $this->transactions;
    }
    public function addTransaction(Transaction $transaction): void
    {
        $this->transactions[] = $transaction;
    }

    public function removeTransaction(Transaction $transaction): void
    {
        $this->transactions = array_filter($this->transactions(), function ($item) use ($transaction) {
            return $item->id() !== $transaction->id();
        });
    }
}
