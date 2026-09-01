<?php

declare(strict_types=1);

/*
 * This file is part of the "netx_fal_api" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Fairway\NetXFalApi\Services;

use Fairway\NetXFalApi\Http\JsonRpcClient;
use Fairway\NetXFalApi\Models\Version;

class VersionService
{
    public function __construct(private readonly JsonRpcClient $rpc)
    {
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

        return array_map(fn (array $row) => new Version($row), $result);
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
