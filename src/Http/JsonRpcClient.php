<?php
namespace Fairway\NetXFalApi\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

class JsonRpcClient
{
    private GuzzleClient $client;
    private string $apiToken;
    private string $baseUri;

    public function __construct(string $baseUri, string $apiToken, string $apiPath = 'api')
    {
        $this->apiToken = $apiToken;
        $this->baseUri = rtrim($baseUri, '/') . '/api/';
        $this->client = new GuzzleClient([
            'base_uri' => rtrim($baseUri, '/') . '/' . trim($apiPath, '/') . '/',
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

    /**
     * @param array<string, scalar|null> $fields
     *
     * @throws GuzzleException
     */
    public function upload(string $method, string $path, string $filePath, ?string $fileName = null, array $fields = []): array
    {
        if (!is_file($filePath)) {
            throw new \InvalidArgumentException("File not found: $filePath");
        }

        $fileHandle = fopen($filePath, 'rb');

        if ($fileHandle === false) {
            throw new \RuntimeException("Unable to open file: $filePath");
        }

        $multipart = [[
            'name' => 'file',
            'contents' => $fileHandle,
            'filename' => $fileName ?? basename($filePath),
        ]];

        foreach ($fields as $name => $value) {
            if ($value === null) {
                continue;
            }

            $multipart[] = [
                'name' => $name,
                'contents' => (string) $value,
            ];
        }

        $client = new GuzzleClient([
            'base_uri' => $this->baseUri,
            'headers' => [
                'Authorization' => 'apiToken ' . $this->apiToken,
            ],
        ]);

        try {
            $response = $client->request($method, ltrim($path, '/'), [
                'multipart' => $multipart,
            ]);
        } finally {
            if (is_resource($fileHandle)) {
                fclose($fileHandle);
            }
        }

        if($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            throw new \RuntimeException(
                sprintf('NetX API Error (748398343): Error statuscode %s', $response->getStatusCode())
            );
        }

        $contents = (string) $response->getBody();

        if ($contents === '') {
            return [];
        }

        if(json_validate($contents)) {
            $body = json_decode($contents, true);
        }
        else
        {
            throw new \RuntimeException(
                'NetX API Error (748398473): Invalid json code'
            );
        }

        if (isset($body['error'])) {
            throw new \RuntimeException(
                sprintf('NetX API Error (%s): %s', $body['error']['code'], $body['error']['message'])
            );
        }

        return $body['result'] ?? $body;
    }
}
