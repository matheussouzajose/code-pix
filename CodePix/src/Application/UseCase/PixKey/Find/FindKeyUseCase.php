<?php

namespace Core\Application\UseCase\PixKey\Find;

use Core\Domain\PixKey\Repository\PixKeyRepositoryInterface;

class FindKeyUseCase
{
    public function __construct(protected PixKeyRepositoryInterface $pixKeyRepository)
    {
    }

    public function __invoke(FindKeyInputDto $input): FindKeyOutputDto
    {
        $data = $this->pixKeyRepository->findByKeyAndByKind(key: $input->key, kind: $input->kind);

        return new FindKeyOutputDto(
            id: $data->id(),
            account: $data->account(),
            kind: $data->kind->value,
            key: $data->key,
            status: $data->status->value,
            createdAt: $data->createdAt()
        );
    }
}
