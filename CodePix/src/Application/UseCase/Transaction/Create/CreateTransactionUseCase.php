<?php

namespace Core\Application\UseCase\Transaction\Create;

use Core\Domain\PixKey\Repository\PixKeyRepositoryInterface;
use Core\Domain\Shared\Event\EventManagerInterface;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;
use Core\Domain\Shared\Repository\TransactionInterface;
use Core\Domain\Transaction\Entity\Transaction;
use Core\Domain\Transaction\Event\TransactionCreatedEvent;
use Core\Domain\Transaction\Repository\TransactionRepositoryInterface;

class CreateTransactionUseCase
{
    public function __construct(
        protected TransactionRepositoryInterface $transactionRepository,
        protected PixKeyRepositoryInterface $pixKeyRepository,
        protected TransactionInterface $transactionDb,
        protected EventManagerInterface $eventManager,
    ) {
    }

    /**
     * @throws NotificationException|\Throwable
     */
    public function __invoke(CreateTransactionInputDto $input): CreateTransactionOutputDto
    {
        try {
            $accountFrom = $this->pixKeyRepository->findAccountById(id: $input->accountId);
            $pixKeyTo = $this->pixKeyRepository->findByKeyAndByKind(
                key: $input->pixKeyTo,
                kind: $input->pixKeyKindTo
            );

            $transaction = new Transaction(
                accountFrom: $accountFrom,
                amount: $input->amount,
                pixKeyTo: $pixKeyTo,
                description: $input->description,
                id: new Uuid($input->externalId)
            );

            $data = $this->transactionRepository->register(transaction: $transaction);

            $this->eventManager->dispatch(
                event: new TransactionCreatedEvent(
                    $transaction,
                    topic: "bank{$pixKeyTo->account()->bank()->code}"
                )
            );

            $this->transactionDb->commit();

            return $this->output(data: $data);
        } catch (\Throwable $th) {
            $this->transactionDb->rollback();
            throw $th;
        }
    }

    /**
     * @throws NotificationException
     */
    private function output(object $data): CreateTransactionOutputDto
    {
        return new CreateTransactionOutputDto(
            id: $data->id,
            accountId: $data->accountFromId(),
            pixKeyId: $data->pixKeyToId(),
            amount: $data->amount,
            status: $data->status->value,
            description: $data->description,
            createdAt: $data->createdAt(),
            pixKeyTo: $data->pixKeyTo
        );
    }
}
