<?php

namespace App\Http\Controllers\Api\BankAccount;

use App\Http\Adapters\ApiAdapter;
use App\Http\Controllers\Controller;
use Core\Ui\Factories\Controller\BankAccount\PaginateBankAccountControllerFactory;
use Core\Ui\Factories\Controller\BankAccount\ShowBankAccountControllerFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BankAccountController extends Controller
{
    public function show(string $id): JsonResponse
    {
        $controller = ShowBankAccountControllerFactory::create();
        $result = ($controller)(id: $id);

        return ApiAdapter::toJson($result, Response::HTTP_OK);
    }

    public function index(Request $request): JsonResponse
    {
        $controller = PaginateBankAccountControllerFactory::create();
        $result = ($controller)(request: $request);

        return ApiAdapter::paginate(result: $result);
    }
}
