<?php

namespace Core\Application\UseCase\BankAccount\Show;

class ShowBankAccountInputDto
{
    public function __construct(public string $id)
    {
    }
}
