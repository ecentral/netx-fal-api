<?php

namespace Fairway\NetXFalApi\Services;

use Fairway\NetXFalApi\Http\JsonRpcClient;
use Fairway\NetXFalApi\Models\Asset;

class AssetService
{
    private JsonRpcClient $rpc;

    public function __construct(JsonRpcClient $rpc)
    {
        $this->rpc = $rpc;
    }

    /**
     * Gets one or more assets using their unique identifiers.
     *
     * @param int[] $ids
     * @param string[] $fields
     * @return Asset[]
     */
    public function getAssets(array $ids, array $fields = ["asset.id", "asset.base","asset.file","asset.proxies","asset.attributes","asset.metadata"]): array
    {
        $result = $this->rpc->call('getAssets', [$ids, ['data' => $fields]]);
        return array_map(fn(array $row) => new Asset($row), $result);
    }

    /**
     * Updates asset filename and/or name.
     *
     * @param int $id
     * @param array $fields
     * @param string[] $data
     * @return Asset
     */
    public function updateAsset(int $id, array $fields, array $data = ["asset.base"]): Asset
    {
        $result = $this->rpc->call('updateAsset', [
            array_merge(['id' => $id], $fields),
            ['data' => $data]
        ]);
        return new Asset($result);
    }

    /**
     * Returns assets contained in a specific folder (optionally recursive).
     *
     * @param int $folderId
     * @param bool $recursive
     * @param int $startIndex
     * @param int $size
     * @param string[] $fields
     * @return Asset[]
     */
    public function getAssetsByFolder(
        int   $folderId,
        bool  $recursive = false,
        int   $startIndex = 0,
        int   $size = 10,
        array $fields = ["asset.id", "asset.base","asset.file","asset.proxies","asset.attributes","asset.metadata"]
    ): array
    {
        $result = $this->rpc->call('getAssetsByFolder', [
            $folderId,
            $recursive,
            [
                'page' => ['startIndex' => $startIndex, 'size' => $size],
                'data' => $fields
            ]
        ]);
        return array_map(fn(array $row) => new Asset($row), $result['results'] ?? []);
    }

    /**
     * Adds an asset to a specific parent folder.
     *
     * @param int $assetId
     * @param int $folderId
     * @param string[] $fields
     * @return Asset
     */
    public function addAssetToFolder(int $assetId, int $folderId, array $fields = ['asset.base']): Asset
    {
        $result = $this->rpc->call('addAssetToFolder', [
            $assetId,
            $folderId,
            ['data' => $fields]
        ]);
        return new Asset($result);
    }

    /**
     * Removes an asset from its parent folder.
     *
     * @param int $assetId
     * @param int $folderId
     * @param string[] $fields
     * @return Asset
     */
    public function removeAssetFromFolder(int $assetId, int $folderId, array $fields = ['asset.base']): Asset
    {
        $result = $this->rpc->call('removeAssetFromFolder', [
            $assetId,
            $folderId,
            ['data' => $fields]
        ]);
        return new Asset($result);
    }

    /**
     * Retrieve pages by asset ID.
     *
     * @param int $assetId
     * @param int $startIndex
     * @param int $size
     * @return array
     */
    public function getPagesByAsset(int $assetId, int $startIndex = 0, int $size = 10): array
    {
        return $this->rpc->call('getPagesByAsset', [
            $assetId,
            ['page' => ['startIndex' => $startIndex, 'size' => $size]]
        ]);
    }

    /**
     * Retrieve keyframes by asset ID.
     *
     * @param int $assetId
     * @param int $startIndex
     * @param int $size
     * @return array
     */
    public function getKeyframesByAsset(int $assetId, int $startIndex = 0, int $size = 10): array
    {
        return $this->rpc->call('getKeyframesByAsset', [
            $assetId,
            ['page' => ['startIndex' => $startIndex, 'size' => $size]]
        ]);
    }

    /**
     * Delete an asset by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteAsset(int $id): bool
    {
        $this->rpc->call('deleteAsset', [$id]);
        return true;
    }
}
