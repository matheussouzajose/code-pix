<?php

namespace Core\Domain\Transaction\Entity;

use Core\Domain\Account\Entity\Account;
use Core\Domain\PixKey\Entity\PixKey;
use Core\Domain\Shared\Entity\Entity;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;
use Core\Domain\Transaction\Enum\StatusTransactionType;
use Core\Domain\Transaction\Factory\TransactionValidatorFactory;
use Core\Domain\Transaction\Validator\TransactionValidator;

class Transaction extends Entity
{
    /**
     * @throws NotificationException
     */
    public function __construct(
        protected Account $accountFrom,
        protected float $amount,
        protected PixKey $pixKeyTo,
        protected string $description,
        protected ?string $cancelDescription = null,
        protected ?Uuid $id = null,
        protected ?\DateTime $createdAt = null,
        protected ?\DateTime $updatedAt = null,
        protected StatusTransactionType $status = StatusTransactionType::Pending
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
        TransactionValidatorFactory::create()->validate($this);

        if ($this->notification->hasErrors()) {
            throw NotificationException::messages(
                messages: $this->notification->messages(TransactionValidator::CONTEXT)
            );
        }
    }

    /**
     * @throws NotificationException
     */
    public function completed(): void
    {
        $this->status = StatusTransactionType::Completed;
        $this->updatedAt = new \DateTime();

        $this->validation();
    }

    /**
     * @throws NotificationException
     */
    public function canceled(string $cancelDescription): void
    {
        $this->status = StatusTransactionType::Canceled;
        $this->cancelDescription = $cancelDescription;
        $this->updatedAt = new \DateTime();

        $this->validation();
    }

    /**
     * @throws NotificationException
     */
    public function confirmed(): void
    {
        $this->status = StatusTransactionType::Confirmed;
        $this->updatedAt = new \DateTime();

        $this->validation();
    }

    public function status(): StatusTransactionType
    {
        return $this->status;
    }

    public function accountFrom(): Account
    {
        return $this->accountFrom;
    }

    public function accountFromId(): string
    {
        return $this->accountFrom->id();
    }

    public function pixKeyTo(): PixKey
    {
        return $this->pixKeyTo;
    }

    public function pixKeyToId(): string
    {
        return $this->pixKeyTo->id();
    }

    public function cancelDescription(): ?string
    {
        return $this->cancelDescription ?? null;
    }
}
