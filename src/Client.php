<?php
namespace Fairway\NetxApi;

use Fairway\NetXFalApi\Http\JsonRpcClient;
use Fairway\NetXFalApi\Services\AssetService;
use Fairway\NetXFalApi\Services\FolderService;
use Fairway\NetXFalApi\Services\CollectionService;

class Client
{
    private JsonRpcClient $rpc;

    public AssetService $assets;
    public FolderService $folders;
    public CollectionService $collections;

    public function __construct(string $baseUri, string $apiToken)
    {
        $this->rpc = new JsonRpcClient($baseUri, $apiToken);

        $this->assets = new AssetService($this->rpc);
        $this->folders = new FolderService($this->rpc);
        $this->collections = new CollectionService($this->rpc);
    }
}
