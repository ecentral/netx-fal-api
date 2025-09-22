<?php
namespace Fairway\NetXFalApi\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

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
                'Authorization'     => 'apiToken '. $this->apiToken,
            ]
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function call(string $method, array $params = [], ?string $id = null): array
    {
        $payload = [
            'json'=>[
                'jsonrpc' => '2.0',
                'method'  => $method,
                'params'  => $params,
                'id'      => $id ?? uniqid(),
            ]
        ];

        $response = $this->client->post('rpc', $payload);

        if($response->getStatusCode() !== 200) {
            throw new \RuntimeException(
                sprintf('NetX API Error (748398342): Error statuscode %s', $response->getStatusCode())
            );
        }
        if(json_validate($response->getBody())) {
            $body = json_decode($response->getBody(), true);
        }
        else
        {
            throw new \RuntimeException(
                'NetX API Error (748398472): Invalid json code'
            );
        }

        if (isset($body['error'])) {
            throw new \RuntimeException(
                sprintf('NetX API Error (%s): %s', $body['error']['code'], $body['error']['message'])
            );
        }

        return $body['result'] ?? [];
    }
}
