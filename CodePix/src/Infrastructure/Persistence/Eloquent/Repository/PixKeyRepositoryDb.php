<?php

namespace Core\Infrastructure\Persistence\Eloquent\Repository;

use App\Models\PixKey as PixKeyModel;
use App\Models\Bank as BankModel;
use App\Models\Account as AccountModel;
use Core\Domain\Account\Entity\Account;
use Core\Domain\Bank\Entity\Bank;
use Core\Domain\PixKey\Entity\PixKey;
use Core\Domain\PixKey\Repository\PixKeyRepositoryInterface;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Infrastructure\Exceptions\NotFoundException;
use Core\Infrastructure\Persistence\Eloquent\Factories\AccountFactory;
use Core\Infrastructure\Persistence\Eloquent\Factories\BankFactory;
use Core\Infrastructure\Persistence\Eloquent\Factories\PixKeyFactory;

class PixKeyRepositoryDb implements PixKeyRepositoryInterface
{
    public function __construct(
        protected PixKeyModel $pixKeyModel,
        protected BankModel $bankModel,
        protected AccountModel $accountModel,
    ) {
    }

    /**
     * @throws NotificationException
     */
    public function register(PixKey $pixKey): PixKey
    {
        $data = $this->pixKeyModel->create([
            'id' => $pixKey->id(),
            'account_id' => $pixKey->accountId(),
            'kind' => $pixKey->kind->value,
            'key' => $pixKey->key,
            'status' => $pixKey->status->value,
        ]);

        return PixKeyFactory::createWithTransactions(data: $data);
    }

    /**
     * @throws NotificationException
     * @throws NotFoundException
     */
    public function findByKeyAndByKind(string $key, string $kind): PixKey
    {
        if (!$data = $this->pixKeyModel->whereKeyAndKind($key, $kind)->first()) {
            throw NotFoundException::itemNotFound($key);
        }
        return PixKeyFactory::createWithTransactions(data: $data);
    }

    public function KeyAndByKindExists(string $key, string $kind): bool
    {
        return $this->pixKeyModel->whereKeyAndKind($key, $kind)->exists();
    }

    /**
     * @throws NotificationException
     */
    public function addBank(Bank $bank): Bank
    {
        $data = $this->bankModel->create([
            'id' => $bank->id(),
            'code' => $bank->code,
            'name' => $bank->name,
            'created_at' => $bank->createdAt()
        ]);

        return BankFactory::createWithAccounts($data);
    }

    /**
     * @throws NotificationException
     * @throws NotFoundException
     */
    public function findBankById(string $id): Bank
    {
        if (!$data = $this->bankModel->find($id)) {
            throw NotFoundException::itemNotFound($id);
        }
        return BankFactory::createWithAccounts($data);
    }

    /**
     * @throws NotificationException
     */
    public function addAccount(Account $account): Account
    {
        $data = $this->accountModel->create([
            'id' => $account->id(),
            'owner_name' => $account->ownerName,
            'number' => $account->number,
            'bank_id' => $account->bankId(),
            'created_at' => $account->createdAt(),
        ]);

        return AccountFactory::createWithPixKeys($data);
    }

    /**
     * @throws NotificationException
     * @throws NotFoundException
     */
    public function findAccountById(string $id): Account
    {
        if (!$data = $this->accountModel->find($id)) {
            throw NotFoundException::itemNotFound($id);
        }
        return AccountFactory::createWithPixKeys($data);
    }
}
