<?php

namespace App\Http\Controllers\Api\BankAccount;

use App\Http\Adapters\ApiAdapter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Ui\Factories\Controller\Transaction\CreateTransactionControllerFactory;
use Core\Ui\Factories\Controller\Transaction\PaginateTransactionControllerFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function index(string $id, Request $request): JsonResponse
    {
        $controller = PaginateTransactionControllerFactory::create();
        $result = ($controller)(bankAccountId: $id, request: $request);

        return ApiAdapter::paginate(result: $result);
    }

    /**
     * @throws NotificationException
     * @throws \Throwable
     */
    public function store(string $id, StoreTransactionRequest $request): JsonResponse
    {
        $controller = CreateTransactionControllerFactory::create();
        $result = ($controller)(bankAccountId: $id, request: $request);

        return ApiAdapter::toJson($result, Response::HTTP_CREATED);
    }
}
