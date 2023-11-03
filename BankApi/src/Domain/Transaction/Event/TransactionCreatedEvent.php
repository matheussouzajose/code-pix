<?php

namespace Core\Domain\Transaction\Event;

use Core\Domain\Shared\Event\EventInterface;
use Core\Domain\Transaction\Entity\Transaction;

class TransactionCreatedEvent implements EventInterface
{
    public function __construct(protected Transaction $transaction, protected string $topic)
    {
    }

    public function getEventName(): string
    {
        return 'created.transaction';
    }

    public function getTopic(): string
    {
        return $this->topic;
    }

    public function getPayload(): array
    {
        return [
            'external_id' => (string) $this->transaction->externalId,
            'account_id' => $this->transaction->bankAccountFromId,
            'amount' => $this->transaction->amount,
            'pix_key_to' => $this->transaction->pixKeyTo,
            'pix_key_kind_to' => $this->transaction->pixKindTo,
            'description' => $this->transaction->description,
            'status' => $this->transaction->status,
        ];

    }
}
