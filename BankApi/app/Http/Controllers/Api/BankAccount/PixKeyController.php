<?php

namespace App\Http\Controllers\Api\BankAccount;

use App\Exceptions\ServerErrorRequestHttpException;
use App\Http\Adapters\ApiAdapter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePixKeyRequest;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Ui\Factories\Controller\PixKey\CreatePixKeyControllerFactory;
use Core\Ui\Factories\Controller\PixKey\ExistPixKeyControllerFactory;
use Core\Ui\Factories\Controller\PixKey\PaginatePixKeyControllerFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PixKeyController extends Controller
{
    public function index(string $id, Request $request): JsonResponse
    {
        $controller = PaginatePixKeyControllerFactory::create();
        $result = ($controller)(bankAccountId: $id, request: $request);

        return ApiAdapter::paginate(result: $result);
    }

    /**
     * @throws NotificationException|\Throwable
     */
    public function store(string $id, StorePixKeyRequest $request): JsonResponse
    {
        $controller = CreatePixKeyControllerFactory::create();
        $result = ($controller)(bankAccountId: $id, request: $request);

        return ApiAdapter::toJson($result, Response::HTTP_CREATED);
    }

    /**
     * @throws ServerErrorRequestHttpException
     */
    public function exist(string $id, string $kind, string $key): JsonResponse
    {
        $controller = ExistPixKeyControllerFactory::create();
        $result = ($controller)(bankAccountId: $id, kind: $kind, key: $key);

        return ApiAdapter::toJson($result, Response::HTTP_OK);
    }
}
