<?php

namespace Core\Application\UseCase\Transaction\Create;

use App\Exceptions\ServerErrorRequestHttpException;
use App\Exceptions\UnprocessableRequestHttpException;
use Core\Application\Interfaces\HttpIntegrationServiceInterface;
use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Domain\Shared\Event\EventManagerInterface;
use Core\Domain\Shared\Exception\InsufficientLimitException;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\Exception\TheSameAccountException;
use Core\Domain\Shared\Repository\TransactionInterface;
use Core\Domain\Transaction\Entity\Transaction;
use Core\Domain\Transaction\Event\TransactionCreatedEvent;
use Core\Domain\Transaction\Repository\TransactionRepositoryInterface;
use Core\Infrastructure\Http\Service\CheckPixKeyRequestService;

class CreateTransactionUseCase
{
    public function __construct(
        protected TransactionRepositoryInterface $transactionRepository,
        protected BankAccountRepositoryInterface $bankAccountRepository,
        protected TransactionInterface $transactionDb,
        protected EventManagerInterface $eventManager,
        protected HttpIntegrationServiceInterface $httpIntegrationService,
    ) {
    }

    /**
     * @throws NotificationException
     * @throws \Throwable
     */
    public function __invoke(CreateTransactionInputDto $input): CreateTransactionOutputDto
    {
        try {
            $this->checkPixKey(pixKindTo: $input->pixKindTo, pixKeyTo: $input->pixKeyTo);

            $bankAccountFrom = $this->bankAccountRepository->findById(id: $input->bankAccountFromId);

            if ( in_array(needle: $input->pixKeyTo, haystack: $bankAccountFrom->pixKeys) ) {
                throw TheSameAccountException::invalid();
            }

            if ( $input->amount > $bankAccountFrom->balance ) {
                throw InsufficientLimitException::invalid();
            }

            $transaction = new Transaction(
                amount: $input->amount,
                description: $input->description,
                bankAccountFromId: $bankAccountFrom->id(),
                pixKeyTo: $input->pixKeyTo,
                pixKindTo: $input->pixKindTo,
            );

            $result = $this->transactionRepository->create(data: $transaction);

            $this->eventManager->dispatch(event: new TransactionCreatedEvent($transaction, topic: 'transactions'));

            $this->transactionDb->commit();

            return $this->output(data: $result);
        } catch (\Throwable $th) {
            $this->transactionDb->rollback();
            throw $th;
        }
    }

    /**
     * @throws UnprocessableRequestHttpException
     * @throws ServerErrorRequestHttpException
     */
    private function checkPixKey(string $pixKindTo, string $pixKeyTo): void
    {
        $checkPixKeyFrom = new CheckPixKeyRequestService(httpIntegrationService: $this->httpIntegrationService);
        if ( !$checkPixKeyFrom->check(kind: $pixKindTo, key: $pixKeyTo) ) {
            throw UnprocessableRequestHttpException::message('The pix key not exists.');
        }
    }

    private function output(Transaction $data): CreateTransactionOutputDto
    {
        return new CreateTransactionOutputDto(
            id: $data->id(),
            externalId: $data->externalId,
            bankAccountFromId: $data->bankAccountFromId,
            pixKeyTo: $data->pixKeyTo,
            pixKindTo: $data->pixKindTo,
            amount: $data->amount,
            description: $data->description,
            status: $data->status->value,
            operation: $data->operation->value,
            createdAt: $data->createdAt()
        );
    }
}
