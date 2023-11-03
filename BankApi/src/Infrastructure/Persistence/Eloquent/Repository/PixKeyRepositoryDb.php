<?php

namespace Core\Infrastructure\Persistence\Eloquent\Repository;

use App\Models\PixKey as PixKeyModel;
use Core\Domain\PixKey\Entity\PixKey;
use Core\Domain\PixKey\Repository\PixKeyInterfaceRepository;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\Repository\PaginationInterface;
use Core\Infrastructure\Exceptions\NotFoundException;
use Core\Infrastructure\Persistence\Eloquent\Factories\PixKeyFactory;
use Core\Infrastructure\Persistence\Eloquent\Presenters\PaginationPresenter;

class PixKeyRepositoryDb implements PixKeyInterfaceRepository
{
    public function __construct(
        protected PixKeyModel $pixKeyModel,
    ) {
    }

    /**
     * @throws NotificationException
     * @throws NotFoundException
     */
    public function create(PixKey $data): PixKey
    {
        $result = $this->pixKeyModel->create([
            'id' => $data->id(),
            'bank_account_id' => $data->bankAccountId(),
            'kind' => $data->kind->value,
            'key' => $data->key,
            'created_at' => $data->createdAt,
        ]);

        return PixKeyFactory::create(model: $result);
    }

    /**
     * @throws NotFoundException
     */
    public function paginate(
        string $bankAccountId,
        string $filter = '',
        string $order = 'DESC',
        int $page = 1,
        int $totalPage = 15
    ): PaginationInterface {
        $result = $this->pixKeyModel->when($filter, function ($query) use ($filter) {
            $query->where('key', 'LIKE', "%{$filter}%");
        })
            ->where('bank_account_id', $bankAccountId)
            ->orderBy('created_at', $order)
            ->paginate($totalPage, ['*'], 'page', $page);

        return new PaginationPresenter($result);
    }

    /**
     * @throws NotFoundException
     */
    public function existPixKey(string $kind, string $key): bool
    {
        return $this->pixKeyModel->whereKindAndKey($kind, $key)->exists();
    }

    /**
     * @throws NotFoundException|NotificationException
     */
    public function findPixKey(string $kind, string $key): PixKey
    {
        if (! $result = $this->pixKeyModel->whereKindAndKey($kind, $key)->first()) {
            throw NotFoundException::itemNotFound($key);
        }

        return PixKeyFactory::create(model: $result);
    }
}
