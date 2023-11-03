<?php

namespace Core\Application\UseCase\PixKey\Paginate;

class PaginatePixKeyInputDto
{
    public function __construct(
        public string $bankAccountId,
        public string $filter = '',
        public string $order = 'DESC',
        public int $page = 1,
        public int $totalPage = 15,
    ) {
    }
}
