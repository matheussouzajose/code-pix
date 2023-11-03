<?php

namespace Core\Domain\Transaction\Entity;

use Core\Domain\Shared\Entity\Entity;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;
use Core\Domain\Transaction\Enum\TransactionOperation;
use Core\Domain\Transaction\Enum\TransactionStatus;
use Core\Domain\Transaction\Factory\TransactionValidatorFactory;
use Core\Domain\Transaction\Validator\TransactionValidator;

class Transaction extends Entity
{
    /**
     * @throws NotificationException
     */
    public function __construct(
        protected float $amount,
        protected string $description,
        protected string $bankAccountFromId,
        protected string $pixKeyTo,
        protected string $pixKindTo,
        protected TransactionStatus $status = TransactionStatus::Pending,
        protected TransactionOperation $operation = TransactionOperation::Debit,
        protected ?Uuid $externalId = null,
        protected ?Uuid $id = null,
        protected ?\DateTime $createdAt = null,
        protected ?\DateTime $updatedAt = null,
    ) {
        parent::__construct();

        $this->addId();
        $this->addCreatedAt();

        $this->externalId = $this->externalId ?? Uuid::random();

        $this->validation();
    }

    /**
     * @throws NotificationException
     */
    public function validation(): void
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
        $this->status = TransactionStatus::Completed;
        $this->updatedAt = new \DateTime();

        $this->validation();
    }

    /**
     * @throws NotificationException
     */
    public function confirmed(): void
    {
        $this->status = TransactionStatus::Confirmed;
        $this->updatedAt = new \DateTime();

        $this->validation();
    }

    /**
     * @throws NotificationException
     */
    public function error(): void
    {
        $this->status = TransactionStatus::Error;
        $this->updatedAt = new \DateTime();

        $this->validation();
    }
}
