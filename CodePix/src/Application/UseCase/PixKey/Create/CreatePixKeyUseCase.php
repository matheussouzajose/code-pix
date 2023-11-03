<?php

namespace Core\Application\UseCase\PixKey\Create;

use Core\Domain\PixKey\Entity\PixKey;
use Core\Domain\PixKey\Enum\KindType;
use Core\Domain\PixKey\Exceptions\PixKeyKindException;
use Core\Domain\PixKey\Repository\PixKeyRepositoryInterface;
use Core\Domain\Shared\Exception\NotificationException;

class CreatePixKeyUseCase
{
    public function __construct(protected PixKeyRepositoryInterface $pixKeyRepository)
    {
    }

    /**
     * @throws NotificationException
     * @throws PixKeyKindException
     */
    public function __invoke(CreatePixKeyInputDto $input): CreatePixKeyOutputDto
    {
        if ($this->pixKeyRepository->KeyAndByKindExists(key: $input->key, kind: $input->kind)) {
            throw PixKeyKindException::alreadyExists(kind: $input->kind, key: $input->key);
        }

        $account = $this->pixKeyRepository->findAccountById(id: $input->accountId);

        $pixKey = new PixKey(
            kind: KindType::tryFrom($input->kind),
            key: $input->key,
            account: $account
        );

        $data = $this->pixKeyRepository->register(pixKey: $pixKey);

        return $this->output(data: $data);
    }

    protected function output(object $data): CreatePixKeyOutputDto
    {
        return new CreatePixKeyOutputDto(
            id: $data->id(),
            status: $data->status->value,
        );
    }
}
