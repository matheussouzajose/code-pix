<?php

namespace Core\Application\UseCase\Transaction\Save;

use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Domain\PixKey\Repository\PixKeyInterfaceRepository;
use Core\Domain\Shared\Event\EventManagerInterface;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;
use Core\Domain\Shared\Repository\TransactionInterface;
use Core\Domain\Transaction\Entity\Transaction;
use Core\Domain\Transaction\Enum\TransactionOperation;
use Core\Domain\Transaction\Enum\TransactionStatus;
use Core\Domain\Transaction\Event\TransactionCreatedEvent;
use Core\Domain\Transaction\Repository\TransactionRepositoryInterface;
use Core\Infrastructure\Exceptions\NotFoundException;

class SaveTransactionUseCase
{
    public function __construct(
        protected BankAccountRepositoryInterface $bankAccountRepository,
        protected TransactionRepositoryInterface $transactionRepository,
        protected PixKeyInterfaceRepository $pixKeyRepository,
        protected TransactionInterface $transactionDb,
        protected EventManagerInterface $eventManager
    ) {
    }

    /**
     * @throws NotificationException
     * @throws NotFoundException
     * @throws \Throwable
     */
    public function __invoke(SaveTransactionInputDto $input): SaveTransactionOutputDto
    {
        try {
            $result = match ($input->status) {
                'pending' => $this->receivedTransaction(data: $input),
                'confirmed' => $this->confirmedTransaction(data: $input),
            };

            $this->eventManager->dispatch(
                event: new TransactionCreatedEvent($result, topic: 'transaction_confirmation')
            );

            $this->transactionDb->commit();

            return $this->output(data: $result);
        } catch (\Throwable $th) {
            $this->transactionDb->rollback();
            throw $th;
        }
    }

    /**
     * @throws NotificationException
     */
    private function receivedTransaction(SaveTransactionInputDto $data): Transaction
    {
        $pixKey = $this->pixKeyRepository->findPixKey(kind: $data->pixKindTo, key: $data->pixKeyTo);

        $transaction = new Transaction(
            amount: $data->amount,
            description: $data->description,
            bankAccountFromId: $data->accountId,
            pixKeyTo: $pixKey->key,
            pixKindTo: $pixKey->kind->value,
            status: TransactionStatus::Confirmed,
            operation: TransactionOperation::Credit,
            externalId: new Uuid($data->externalId)
        );

        $this->transactionRepository->create(data: $transaction);

        $bankAccount = $this->bankAccountRepository->findById(id: $pixKey->bankAccountId());
        $bankAccount->creditBalance($transaction->amount);
        $this->bankAccountRepository->save($bankAccount);

        return $transaction;
    }

    /**
     * @throws NotificationException
     */
    private function confirmedTransaction(SaveTransactionInputDto $data): Transaction
    {
        $transaction = $this->transactionRepository->findByExternalId(externalId: $data->externalId);
        $transaction->completed();

        $bankAccount = $this->bankAccountRepository->findById(id: $data->accountId);
        $bankAccount->debitBalance($transaction->amount);
        $this->bankAccountRepository->save($bankAccount);

        return $this->transactionRepository->save(transaction: $transaction);
    }

    private function output(Transaction $data): SaveTransactionOutputDto
    {
        return new SaveTransactionOutputDto(
            id: $data->id(),
            externalId: $data->externalId,
            status: $data->status->value,
            updatedAt: $data->updatedAt()
        );
    }
}
