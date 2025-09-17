<?php
namespace Fairway\NetXFalApi\Services;

use Fairway\NetXFalApi\Http\JsonRpcClient;
use Fairway\NetXFalApi\Models\Asset;

class FileImportService
{
    private JsonRpcClient $rpc;

    public function __construct(JsonRpcClient $rpc)
    {
        $this->rpc = $rpc;
    }

    /**
     * Import a new asset from a file.
     *
     * @param string $filePath  Local file path
     * @param int|null $folderId Optional folder ID to place the asset
     * @param string[] $fields
     * @return Asset
     */
    public function importAsset(string $filePath, ?int $folderId = null, array $fields = ['asset.base']): Asset
    {
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException("File not found: $filePath");
        }

        $result = $this->rpc->call('importAsset', [
            [
                'file' => base64_encode(file_get_contents($filePath)),
                'fileName' => basename($filePath),
                'folderId' => $folderId
            ],
            ['data' => $fields]
        ]);

        return new Asset($result);
    }

    /**
     * Upload a new version of an existing asset.
     *
     * @param int $assetId
     * @param string $filePath
     * @param string[] $fields
     * @return Asset
     */
    public function versionAsset(int $assetId, string $filePath, array $fields = ['asset.base']): Asset
    {
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException("File not found: $filePath");
        }

        $result = $this->rpc->call('versionAsset', [
            $assetId,
            [
                'file' => base64_encode(file_get_contents($filePath)),
                'fileName' => basename($filePath)
            ],
            ['data' => $fields]
        ]);

        return new Asset($result);
    }
}
