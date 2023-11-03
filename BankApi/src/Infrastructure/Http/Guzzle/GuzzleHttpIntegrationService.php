<?php

namespace Core\Infrastructure\Http\Guzzle;

use Core\Application\Interfaces\HttpIntegrationServiceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GuzzleHttpIntegrationService implements HttpIntegrationServiceInterface
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('app.url_code_pix'),
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function get(string $url, array $options = []): array
    {
        $response = $this->client->get($url, $options);

        return json_decode($response->getBody(), true);
    }

    /**
     * @throws GuzzleException
     */
    public function post(string $url, array $data, array $options = []): array
    {
        $response = $this->client->post($url, array_merge($options, ['json' => $data]));

        return json_decode($response->getBody(), true);
    }
}
