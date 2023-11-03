<?php

namespace Core\Infrastructure\Http\Service;

use App\Exceptions\ServerErrorRequestHttpException;
use App\Exceptions\UnprocessableRequestHttpException;
use Core\Application\Interfaces\HttpIntegrationServiceInterface;
use GuzzleHttp\Exception\ClientException;

class CreatePixKeyRequestService
{
    public function __construct(protected HttpIntegrationServiceInterface $httpIntegrationService)
    {
    }

    /**
     * @throws ServerErrorRequestHttpException
     * @throws UnprocessableRequestHttpException
     */
    public function create(string $bankAccountId, string $kind, string $key): void
    {
        try {
            $this->httpIntegrationService->post('pix-keys', [
                'account_id' => $bankAccountId,
                'kind' => $kind,
                'key' => $key,
            ]);
        } catch (ClientException $th) {
            if ($th->hasResponse() && $th->getResponse()->getStatusCode() === 422) {
                $body = json_decode($th->getResponse()->getBody());
                throw UnprocessableRequestHttpException::message($body->message);
            }
            throw ServerErrorRequestHttpException::message();
        }
    }
}
