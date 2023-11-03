<?php

namespace Core\Infrastructure\Persistence\Eloquent\Repository;

use App\Models\Transaction as TransactionModel;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\Repository\PaginationInterface;
use Core\Domain\Transaction\Entity\Transaction;
use Core\Domain\Transaction\Repository\TransactionRepositoryInterface;
use Core\Infrastructure\Exceptions\NotFoundException;
use Core\Infrastructure\Persistence\Eloquent\Factories\TransactionFactory;
use Core\Infrastructure\Persistence\Eloquent\Presenters\PaginationPresenter;

class TransactionRepositoryDb implements TransactionRepositoryInterface
{
    public function __construct(
        protected TransactionModel $transactionModel,
    ) {
    }

    public function create(Transaction $data): Transaction
    {
        $result = $this->transactionModel->create([
            'id' => $data->id(),
            'external_id' => $data->externalId,
            'bank_account_from_id' => $data->bankAccountFromId,
            'pix_key_key' => $data->pixKeyTo,
            'pix_key_kind' => $data->pixKindTo,
            'status' => $data->status->value,
            'operation' => $data->operation->value,
            'amount' => $data->amount,
            'description' => $data->description,
            'created_at' => $data->createdAt,
        ]);

        return TransactionFactory::create(model: $result);
    }

    public function paginate(
        string $bankAccountId,
        string $filter = '',
        string $order = 'DESC',
        int $page = 1,
        int $totalPage = 15
    ): PaginationInterface {
        $result = $this->transactionModel->when($filter, function ($query) use ($filter) {
            $query->where('pix_key_to_key', 'LIKE', "%{$filter}%");
        })
            ->where('bank_account_from_id', $bankAccountId)
            ->orderBy('created_at', $order)
            ->paginate($totalPage, ['*'], 'page', $page);

        return new PaginationPresenter($result);
    }

    /**
     * @throws NotificationException
     * @throws NotFoundException
     */
    public function findByExternalId(string $externalId): Transaction
    {
        if ( !$result = $this->transactionModel
            ->whereExternalIdAndOperation($externalId, 'debit')
            ->first()
        ) {
            throw NotFoundException::itemNotFound($externalId);
        }

        return TransactionFactory::create(model: $result);
    }

    /**
     * @throws NotificationException
     * @throws NotFoundException
     */
    public function save(Transaction $transaction): Transaction
    {
        if ( !$result = $this->transactionModel
            ->whereExternalIdAndOperation($transaction->externalId, 'debit')
            ->first()
        ) {
            throw NotFoundException::itemNotFound($transaction->externalId);
        }

        $result->status = $transaction->status->value;
        $result->updated_at = $transaction->updatedAt();

        $result->save();

        return TransactionFactory::create(model: $result);
    }
}
