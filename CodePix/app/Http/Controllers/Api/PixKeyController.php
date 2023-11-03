<?php

namespace App\Http\Controllers\Api;

use App\Http\Adapters\ApiAdapter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePixKeyRequest;
use App\Http\Resources\PixKeyResource;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Ui\Api\Controller\PixKey\CreatePixKeyController;
use Core\Ui\Api\Controller\PixKey\FindPixKeyController;
use Core\Ui\Factories\UseCase\PixKey\CreatePixKeyUseCaseFactory;
use Core\Ui\Factories\UseCase\PixKey\FindPixKeyUseCaseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PixKeyController extends Controller
{
    public function find(Request $request): PixKeyResource
    {
        $controller = new FindPixKeyController(
            useCase: FindPixKeyUseCaseFactory::create()
        );
        $result = ($controller)($request);

        return new PixKeyResource($result);
    }

    /**
     * @throws NotificationException
     */
    public function store(StorePixKeyRequest $request): JsonResponse
    {
        $controller = new CreatePixKeyController(
            useCase: CreatePixKeyUseCaseFactory::create()
        );
        $result = ($controller)($request);

        return ApiAdapter::toJson(data: $result, statusCode: Response::HTTP_CREATED);
    }
}
