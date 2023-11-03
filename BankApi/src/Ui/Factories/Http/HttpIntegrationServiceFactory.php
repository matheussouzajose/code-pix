<?php

namespace Core\Ui\Factories\Http;

use Core\Application\Interfaces\HttpIntegrationServiceInterface;
use Core\Infrastructure\Http\Guzzle\GuzzleHttpIntegrationService;

class HttpIntegrationServiceFactory
{
    public static function create(): HttpIntegrationServiceInterface
    {
        return new GuzzleHttpIntegrationService();
    }
}
