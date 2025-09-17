<?php
namespace Fairway\NetXFalApi\Http;

use GuzzleHttp\Client as GuzzleClient;

class JsonRpcClient
{
    private GuzzleClient $client;
    private string $apiToken;

    public function __construct(string $baseUri, string $apiToken)
    {
        $this->apiToken = $apiToken;
        $this->client = new GuzzleClient([
            'base_uri' => rtrim($baseUri, '/') . '/api/',
            'headers'  => [
                'Content-Type' => 'application/json',
                'apiToken'     => $this->apiToken,
            ]
        ]);
    }

    public function call(string $method, array $params = [], ?string $id = null): array
    {
        $payload = [
            'jsonrpc' => '2.0',
            'method'  => $method,
            'params'  => $params,
            'id'      => $id ?? uniqid()
        ];

        $response = $this->client->post('rpc', [
            'json' => $payload
        ]);

        $body = json_decode((string) $response->getBody(), true);

        if (isset($body['error'])) {
            throw new \RuntimeException(
                sprintf("NetX API Error (%s): %s", $body['error']['code'], $body['error']['message'])
            );
        }

        return $body['result'] ?? [];
    }
}
