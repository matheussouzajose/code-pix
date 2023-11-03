<?php

namespace Core\Infrastructure\Persistence\Eloquent\Repository;

use App\Models\BankAccount as BankAccountModel;
use Core\Domain\BankAccount\Entity\BankAccount;
use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\Repository\PaginationInterface;
use Core\Infrastructure\Exceptions\NotFoundException;
use Core\Infrastructure\Persistence\Eloquent\Factories\BankAccountFactory;
use Core\Infrastructure\Persistence\Eloquent\Presenters\PaginationPresenter;

class BankAccountRepositoryDb implements BankAccountRepositoryInterface
{
    public function __construct(protected BankAccountModel $bankAccountModel)
    {
    }

    /**
     * @throws NotFoundException
     * @throws NotificationException
     */
    public function findById(string $id): BankAccount
    {
        if ( !$data = $this->bankAccountModel->find($id) ) {
            throw NotFoundException::itemNotFound($id);
        }

        return BankAccountFactory::create(model: $data);
    }

    /**
     * @throws NotFoundException
     * @throws NotificationException
     */
    public function save(BankAccount $bankAccount): BankAccount
    {
        if ( !$data = $this->bankAccountModel->find($bankAccount->id()) ) {
            throw NotFoundException::itemNotFound($bankAccount->id());
        }

        $data->balance = $bankAccount->balance;
        $data->updated_at = $bankAccount->updatedAt();
        $data->save();

        return BankAccountFactory::create(model: $data);
    }

    public function paginate(
        string $filter = '',
        string $order = 'DESC',
        int $page = 1,
        int $totalPage = 15
    ): PaginationInterface {
        $result = $this->bankAccountModel->when($filter, function ($query) use ($filter) {
            $query->where('owner_name', 'LIKE', "%{$filter}%");
        })
            ->orderBy('created_at', $order)
            ->paginate($totalPage, ['*'], 'page', $page);

        return new PaginationPresenter($result);
    }
}
