<?php

namespace Core\Infrastructure\Http\Service;

use App\Exceptions\ServerErrorRequestHttpException;
use Core\Application\Interfaces\HttpIntegrationServiceInterface;
use GuzzleHttp\Exception\RequestException;

class CheckPixKeyRequestService
{
    public function __construct(protected HttpIntegrationServiceInterface $httpIntegrationService)
    {
    }

    /**
     * @throws ServerErrorRequestHttpException
     */
    public function check(string $kind, string $key): bool
    {
        try {
            $this->httpIntegrationService->get("pix-keys/{$kind}/{$key}");

            return true;
        } catch (RequestException $th) {
            if ($th->hasResponse() && $th->getResponse()->getStatusCode() === 404) {
                return false;
            }
            throw ServerErrorRequestHttpException::message();
        }
    }
}
