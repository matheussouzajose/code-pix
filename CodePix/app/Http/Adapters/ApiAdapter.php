<?php

namespace App\Http\Adapters;

use App\Http\Resources\DefaultResource;
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
}
