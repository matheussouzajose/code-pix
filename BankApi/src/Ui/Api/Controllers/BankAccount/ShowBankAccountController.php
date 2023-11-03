<?php

namespace Core\Ui\Api\Controllers\BankAccount;

use Core\Application\UseCase\BankAccount\Show\ShowBankAccountInputDto;
use Core\Application\UseCase\BankAccount\Show\ShowBankAccountOutputDto;
use Core\Application\UseCase\BankAccount\Show\ShowBankAccountUseCase;

class ShowBankAccountController
{
    public function __construct(protected ShowBankAccountUseCase $showBankAccountUseCase)
    {
    }

    public function __invoke(string $id): ShowBankAccountOutputDto
    {
        return ($this->showBankAccountUseCase)(input: $this->createFromRequest(id: $id));
    }

    private function createFromRequest(string $id): ShowBankAccountInputDto
    {
        return new ShowBankAccountInputDto(id: $id);
    }
}
