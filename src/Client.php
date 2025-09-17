<?php
namespace Fairway\NetXFalApi;

use Fairway\NetXFalApi\Http\JsonRpcClient;
use Fairway\NetXFalApi\Services\AssetService;
use Fairway\NetXFalApi\Services\AttributeService;
use Fairway\NetXFalApi\Services\FileImportService;
use Fairway\NetXFalApi\Services\FolderService;
use Fairway\NetXFalApi\Services\CollectionService;
use Fairway\NetXFalApi\Services\MiscService;
use Fairway\NetXFalApi\Services\SearchService;
use Fairway\NetXFalApi\Services\VersionService;
use Fairway\NetXFalApi\Services\ViewService;

class Client
{
    private JsonRpcClient $jsonRpcClient;
    public AssetService $assetService;
    public FolderService $folderService;
    public CollectionService $collectionService;
    public ViewService $viewsService;
    public VersionService $versionsService;
    public SearchService $searchService;
    public MiscService $miscService;
    public AttributeService $attributeService;
    public FileImportService  $fileImportService;


    public function __construct(string $baseUri, string $apiToken)
    {
        $this->jsonRpcClient = new JsonRpcClient($baseUri, $apiToken);

        $this->assetService = new AssetService($this->jsonRpcClient);
        $this->folderService = new FolderService($this->jsonRpcClient);
        $this->collectionService = new CollectionService($this->jsonRpcClient);
        $this->viewsService = new ViewService($this->jsonRpcClient);
        $this->versionsService = new VersionService($this->jsonRpcClient);
        $this->searchService = new SearchService($this->jsonRpcClient);
        $this->miscService = new MiscService($this->jsonRpcClient);
        $this->attributeService = new AttributeService($this->jsonRpcClient);
        $this->fileImportService = new FileImportService($this->jsonRpcClient);
    }
}
