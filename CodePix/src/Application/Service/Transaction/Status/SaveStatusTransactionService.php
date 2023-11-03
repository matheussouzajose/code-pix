<?php

namespace Core\Application\Service\Transaction\Status;

use Core\Application\UseCase\Transaction\Status\SaveTransactionInputDto;
use Core\Application\UseCase\Transaction\Status\SaveTransactionOutputDto;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Transaction\Enum\StatusTransactionType;
use Core\Domain\Transaction\Repository\TransactionRepositoryInterface;

class SaveStatusTransactionService
{
    public function __construct(protected TransactionRepositoryInterface $transactionRepository)
    {
    }

    /**
     * @throws NotificationException
     */
    public function __invoke(StatusTransactionType $statusTransactionType, SaveTransactionInputDto $input): SaveTransactionOutputDto
    {
        $transaction = $this->transactionRepository->findById(id: $input->id);

        $action = $statusTransactionType->value;
        $transaction->$action($input->reason ?? null);

        $result = $this->transactionRepository->save(transaction: $transaction);
        return $this->output(data: $result);
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
