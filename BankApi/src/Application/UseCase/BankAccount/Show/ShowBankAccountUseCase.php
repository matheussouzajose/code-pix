<?php

namespace Core\Application\UseCase\BankAccount\Show;

use Core\Domain\BankAccount\Entity\BankAccount;
use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;

class ShowBankAccountUseCase
{
    public function __construct(protected BankAccountRepositoryInterface $bankAccountRepository)
    {
    }

    public function __invoke(ShowBankAccountInputDto $input): ShowBankAccountOutputDto
    {
        $bankAccount = $this->bankAccountRepository->findById(id: $input->id);

        return $this->output(bankAccount: $bankAccount);
    }

    private function output(BankAccount $bankAccount): ShowBankAccountOutputDto
    {
        return new ShowBankAccountOutputDto(
            id: $bankAccount->id(),
            number: $bankAccount->number,
            ownerName: $bankAccount->ownerName,
            balance: $bankAccount->balance,
            createdAt: $bankAccount->createdAt(),

        );
    }
}
