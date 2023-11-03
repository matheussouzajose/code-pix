<?php

namespace Core\Domain\PixKey\Entity;

use Core\Domain\BankAccount\Entity\BankAccount;
use Core\Domain\PixKey\Enum\PixKeyKind;
use Core\Domain\PixKey\Factory\PixKeyValidatorFactory;
use Core\Domain\PixKey\Validator\PixKeyValidator;
use Core\Domain\Shared\Entity\Entity;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;

class PixKey extends Entity
{
    /**
     * @throws NotificationException
     */
    public function __construct(
        protected string $key,
        protected PixKeyKind $kind,
        protected BankAccount $bankAccount,
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
        PixKeyValidatorFactory::create()->validate($this);

        if ($this->notification->hasErrors()) {
            throw NotificationException::messages(
                messages: $this->notification->messages(PixKeyValidator::CONTEXT)
            );
        }
    }

    public function bankAccountId(): string
    {
        return $this->bankAccount->id();
    }
}
