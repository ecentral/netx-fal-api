<?php

declare(strict_types=1);

/*
 * This file is part of the "netx_fal_api" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Fairway\NetXFalApi;

use Fairway\NetXFalApi\Http\JsonRpcClient;
use Fairway\NetXFalApi\Services\AssetService;
use Fairway\NetXFalApi\Services\AttributeService;
use Fairway\NetXFalApi\Services\CollectionService;
use Fairway\NetXFalApi\Services\FileImportService;
use Fairway\NetXFalApi\Services\FolderService;
use Fairway\NetXFalApi\Services\MiscService;
use Fairway\NetXFalApi\Services\SearchService;
use Fairway\NetXFalApi\Services\VersionService;
use Fairway\NetXFalApi\Services\ViewService;

class Client
{
    private JsonRpcClient $jsonRpcClient;
    public ?AssetService $assetService = null;
    public ?FolderService $folderService = null;
    public ?CollectionService $collectionService = null;
    public ?ViewService $viewsService = null;
    public ?VersionService $versionsService = null;
    public ?SearchService $searchService = null;
    public ?MiscService $miscService = null;
    public ?AttributeService $attributeService = null;
    public ?FileImportService  $fileImportService = null;


    public function __construct(string $baseUri, string $apiToken, string $apiPath = 'api')
    {
        $this->jsonRpcClient = new JsonRpcClient($baseUri, $apiToken, $apiPath);
    }

    public function assetService(): AssetService
    {
        if ($this->assetService === null) {
            $this->assetService = new AssetService($this->jsonRpcClient);
        }
        return $this->assetService;
    }

    public function collectionService(): CollectionService
    {
        if ($this->collectionService === null) {
            $this->collectionService = new CollectionService($this->jsonRpcClient);
        }
        return $this->collectionService;
    }

    public function viewsService(): ViewService
    {
        if ($this->viewsService == null) {
            $this->viewsService = new ViewService($this->jsonRpcClient);
        }
        return $this->viewsService;
    }

    public function versionsService(): VersionService
    {
        if ($this->versionsService == null) {
            $this->versionsService = new VersionService($this->jsonRpcClient);
        }
        return $this->versionsService;
    }

    public function searchService(): SearchService
    {
        if ($this->searchService == null) {
            $this->searchService = new SearchService($this->jsonRpcClient);
        }
        return $this->searchService;
    }

    public function miscService(): MiscService
    {
        if ($this->miscService == null) {
            $this->miscService = new MiscService($this->jsonRpcClient);
        }
        return $this->miscService;
    }

    public function attributeService(): AttributeService
    {
        if ($this->attributeService == null) {
            $this->attributeService = new AttributeService($this->jsonRpcClient);
        }
        return $this->attributeService;
    }

    public function fileImportService(): FileImportService
    {
        if ($this->fileImportService == null) {
            $this->fileImportService = new FileImportService($this->jsonRpcClient);
        }
        return $this->fileImportService;
    }

    public function folderService(): FolderService
    {
        if ($this->folderService == null) {
            $this->folderService = new FolderService($this->jsonRpcClient);
        }
        return $this->folderService;
    }
}
