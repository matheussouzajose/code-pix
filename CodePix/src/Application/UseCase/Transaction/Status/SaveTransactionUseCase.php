<?php

namespace Core\Application\UseCase\Transaction\Status;

use Core\Domain\Shared\Event\EventManagerInterface;
use Core\Domain\Shared\Repository\TransactionInterface;
use Core\Domain\Transaction\Event\TransactionCreatedEvent;
use Core\Domain\Transaction\Repository\TransactionRepositoryInterface;

class SaveTransactionUseCase
{
    public function __construct(
        protected TransactionRepositoryInterface $transactionRepository,
        protected TransactionInterface $transactionDb,
        protected EventManagerInterface $eventManager
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function __invoke(SaveTransactionInputDto $input): SaveTransactionOutputDto
    {
        try {
            $transaction = $this->transactionRepository->findById(id: $input->externalId);

            $action = $input->status;
            $transaction->$action($input->reason ?? null);

            $result = $this->transactionRepository->save(transaction: $transaction);

            if ($action !== 'completed') {
                $this->eventManager->dispatch(
                    event: new TransactionCreatedEvent(
                        $transaction,
                        topic: "bank{$transaction->pixKeyTo()->account()->bank()->code}"
                    )
                );
            }

            $this->transactionDb->commit();
            return $this->output(data: $result);
        } catch (\Throwable $th) {
            $this->transactionDb->rollback();
            throw $th;
        }
    }

    private function output(object $data): SaveTransactionOutputDto
    {
        return new SaveTransactionOutputDto(
            id: $data->id,
            accountId: $data->accountFromId(),
            pixKeyId: $data->pixKeyToId(),
            amount: $data->amount,
            status: $data->status->value,
            description: $data->description,
            createdAt: $data->createdAt(),
            accountFrom: $data->accountFrom()
        );
    }
}
