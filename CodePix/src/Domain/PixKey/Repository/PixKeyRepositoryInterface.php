<?php

namespace Core\Domain\PixKey\Repository;

use Core\Domain\Account\Entity\Account;
use Core\Domain\Bank\Entity\Bank;
use Core\Domain\PixKey\Entity\PixKey;

interface PixKeyRepositoryInterface
{
    public function register(PixKey $pixKey): PixKey;

    public function findByKeyAndByKind(string $key, string $kind): PixKey;

    public function addBank(Bank $bank): Bank;

    public function findBankById(string $id): Bank;


    public function addAccount(Account $account): Account;

    public function findAccountById(string $id): Account;

}
