<?php

namespace App\Http\Adapters;

use App\Http\Resources\DefaultResource;
use Core\Domain\Shared\Repository\PaginationInterface;
use Illuminate\Http\JsonResponse;

class ApiAdapter
{
    public static function toJson(object $data, int $statusCode = 200, array $additional = []): JsonResponse
    {
        return (new DefaultResource($data))
            ->additional($additional)
            ->response()
            ->setStatusCode($statusCode);
    }

    public static function paginate(PaginationInterface $result, int $statusCode = 200): JsonResponse
    {
        return DefaultResource::collection($result->items())
            ->additional([
                'meta' => [
                    'total' => $result->total(),
                    'current_page' => $result->currentPage(),
                    'last_page' => $result->lastPage(),
                    'first_page' => $result->firstPage(),
                    'per_page' => $result->perPage(),
                    'to' => $result->to(),
                    'from' => $result->from(),
                ],
            ])
            ->response()
            ->setStatusCode($statusCode);
    }
}
