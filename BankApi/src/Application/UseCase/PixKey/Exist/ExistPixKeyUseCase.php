<?php

namespace Core\Application\UseCase\PixKey\Exist;

use App\Exceptions\ServerErrorRequestHttpException;
use Core\Application\Interfaces\HttpIntegrationServiceInterface;
use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Infrastructure\Http\Service\CheckPixKeyRequestService;

class ExistPixKeyUseCase
{
    public function __construct(
        protected BankAccountRepositoryInterface $bankAccountRepository,
        protected HttpIntegrationServiceInterface $httpIntegrationService
    ) {
    }

    /**
     * @throws ServerErrorRequestHttpException
     */
    public function __invoke(ExistPixKeyInputDto $input): ExistPixKeyOutputDto
    {
        $checkPixKey = new CheckPixKeyRequestService(httpIntegrationService: $this->httpIntegrationService);
        $exist = $checkPixKey->check(kind: $input->kind, key: $input->key);

        return $this->output(data: $exist);
    }

    private function output(bool $data): ExistPixKeyOutputDto
    {
        return new ExistPixKeyOutputDto(
            exist: $data
        );
    }
}
