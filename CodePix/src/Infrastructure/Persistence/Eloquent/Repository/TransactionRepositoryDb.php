<?php

namespace Core\Infrastructure\Persistence\Eloquent\Repository;

use App\Models\Transaction as TransactionModel;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Transaction\Entity\Transaction;
use Core\Domain\Transaction\Repository\TransactionRepositoryInterface;
use Core\Infrastructure\Exceptions\NotFoundException;
use Core\Infrastructure\Persistence\Eloquent\Factories\TransactionFactory;

class TransactionRepositoryDb implements TransactionRepositoryInterface
{
    public function __construct(protected TransactionModel $transactionModel)
    {
    }


    /**
     * @throws NotificationException
     */
    public function register(Transaction $transaction): Transaction
    {
        $data = $this->transactionModel->create([
            'id' => $transaction->id(),
            'account_id' => $transaction->accountFromId(),
            'pix_key_id' => $transaction->pixKeyToId(),
            'amount' => $transaction->amount,
            'status' => $transaction->status()->value,
            'description' => $transaction->description,
            'cancel_description' => $transaction->cancelDescription(),
        ]);

        return TransactionFactory::create(data: $data);
    }

    /**
     * @throws NotificationException
     * @throws NotFoundException
     */
    public function save(Transaction $transaction): Transaction
    {
        if (!$data = $this->transactionModel->find($transaction->id())) {
            throw NotFoundException::itemNotFound($transaction->id());
        }

        $data->status = $transaction->status()->value;
        $data->updated_at = $transaction->updatedAt();
        $data->cancel_description = $transaction->cancelDescription();

        $data->save();

        return TransactionFactory::create(data: $data);
    }

    /**
     * @throws NotificationException
     * @throws NotFoundException
     */
    public function findById(string $id): Transaction
    {
        if (!$data = $this->transactionModel->find($id)) {
            throw NotFoundException::itemNotFound($id);
        }
        return TransactionFactory::create(data: $data);
    }
}
