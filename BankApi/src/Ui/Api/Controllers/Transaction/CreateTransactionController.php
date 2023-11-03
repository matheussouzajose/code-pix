<?php

namespace Core\Ui\Api\Controllers\Transaction;

use Core\Application\UseCase\Transaction\Create\CreateTransactionInputDto;
use Core\Application\UseCase\Transaction\Create\CreateTransactionOutputDto;
use Core\Application\UseCase\Transaction\Create\CreateTransactionUseCase;
use Core\Domain\Shared\Exception\NotificationException;

class CreateTransactionController
{
    public function __construct(protected CreateTransactionUseCase $createTransactionUseCase)
    {
    }

    /**
     * @throws NotificationException|\Throwable
     */
    public function __invoke(string $bankAccountId, object $request): CreateTransactionOutputDto
    {
        return ($this->createTransactionUseCase)(
            input: $this->createFromRequest(bankAccountId: $bankAccountId, request: $request)
        );
    }

    private function createFromRequest(string $bankAccountId, object $request): CreateTransactionInputDto
    {
        return new CreateTransactionInputDto(
            bankAccountFromId: $bankAccountId,
            pixKeyTo: $request->pix_key_to,
            pixKindTo: $request->pix_kind_to,
            amount: (float) $request->amount,
            description: $request->description,
        );
    }
}
