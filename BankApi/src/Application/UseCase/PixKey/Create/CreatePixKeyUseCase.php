<?php

namespace Core\Application\UseCase\PixKey\Create;

use App\Exceptions\ServerErrorRequestHttpException;
use App\Exceptions\UnprocessableRequestHttpException;
use Core\Application\Interfaces\HttpIntegrationServiceInterface;
use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Domain\PixKey\Entity\PixKey;
use Core\Domain\PixKey\Enum\PixKeyKind;
use Core\Domain\PixKey\Repository\PixKeyInterfaceRepository;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\Repository\TransactionInterface;
use Core\Infrastructure\Http\Service\CheckPixKeyRequestService;
use Core\Infrastructure\Http\Service\CreatePixKeyRequestService;

class CreatePixKeyUseCase
{
    public function __construct(
        protected BankAccountRepositoryInterface $bankAccountRepository,
        protected PixKeyInterfaceRepository $pixKeyInterfaceRepository,
        protected TransactionInterface $transaction,
        protected HttpIntegrationServiceInterface $httpIntegrationService
    ) {
    }

    /**
     * @throws NotificationException|\Throwable
     */
    public function __invoke(CreatePixKeyInputDto $input): CreatePixKeyOutputDto
    {
        try {
            $bankAccount = $this->bankAccountRepository->findById(id: $input->bankAccountId);

            $this->checkPixService(kind: $input->kind, key: $input->key);
            $this->createPixService(input: $input);

            $pixKey = new PixKey(
                key: $input->key,
                kind: PixKeyKind::tryFrom($input->kind),
                bankAccount: $bankAccount
            );

            $result = $this->pixKeyInterfaceRepository->create(data: $pixKey);

            $this->transaction->commit();

            return $this->output(data: $result);
        } catch (\Throwable $th) {
            $this->transaction->rollback();
            throw $th;
        }
    }

    /**
     * @throws ServerErrorRequestHttpException
     * @throws UnprocessableRequestHttpException
     */
    private function checkPixService(string $kind, string $key): void
    {
        $checkPixKey = new CheckPixKeyRequestService(httpIntegrationService: $this->httpIntegrationService);
        if ($checkPixKey->check(kind: $kind, key: $key)) {
            throw UnprocessableRequestHttpException::message('The key has already been taken');
        }
    }

    /**
     * @throws UnprocessableRequestHttpException
     * @throws ServerErrorRequestHttpException
     */
    private function createPixService(CreatePixKeyInputDto $input): void
    {
        $checkPixKey = new CreatePixKeyRequestService(httpIntegrationService: $this->httpIntegrationService);
        $checkPixKey->create(bankAccountId: $input->bankAccountId, kind: $input->kind, key: $input->key);
    }

    private function output(PixKey $data): CreatePixKeyOutputDto
    {
        return new CreatePixKeyOutputDto(
            id: $data->id(),
            kind: $data->kind->value,
            key: $data->key,
            bankAccount: $data->bankAccount,
            createdAt: $data->createdAt()
        );
    }
}
