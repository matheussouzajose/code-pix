<?php

namespace Core\Domain\PixKey\Repository;

use Core\Domain\PixKey\Entity\PixKey;
use Core\Domain\Shared\Repository\PaginationInterface;

interface PixKeyInterfaceRepository
{
    public function create(PixKey $data): PixKey;

    public function paginate(
        string $bankAccountId,
        string $filter = '',
        string $order = 'DESC',
        int $page = 1,
        int $totalPage = 15
    ): PaginationInterface;

    public function existPixKey(string $kind, string $key): bool;

    public function findPixKey(string $kind, string $key): PixKey;
}
