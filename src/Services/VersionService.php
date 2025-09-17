<?php
namespace Fairway\NetXFalApi\Services;

use Fairway\NetXFalApi\Http\JsonRpcClient;
use Fairway\NetXFalApi\Models\Version;

class VersionService
{
    private JsonRpcClient $rpc;

    public function __construct(JsonRpcClient $rpc)
    {
        $this->rpc = $rpc;
    }

    /**
     * Get all versions for a specific asset.
     *
     * @param int $assetId
     * @param int $startIndex
     * @param int $size
     * @return Version[]
     */
    public function getVersionsByAsset(int $assetId, int $startIndex = 0, int $size = 10): array
    {
        $result = $this->rpc->call('getVersionsByAsset', [
            $assetId,
            ['page' => ['startIndex' => $startIndex, 'size' => $size]]
        ]);

        return array_map(fn(array $row) => new Version($row), $result);
    }

    /**
     * Delete a specific version of an asset.
     *
     * @param int $versionId
     * @return bool
     */
    public function deleteVersion(int $versionId): bool
    {
        $this->rpc->call('deleteVersion', [$versionId]);
        return true;
    }
}
