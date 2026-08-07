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
    public function importAsset(string $filePath, ?int $folderId = null, array $fields = ['asset.base'], ?string $fileName = null): Asset
    {
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException("File not found: $filePath");
        }

        $result = $this->rpc->upload('POST', 'import/asset', $filePath, $fileName, [
            'fileName' => $fileName ?? basename($filePath),
            'folderId' => $folderId,
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

        $result = $this->rpc->upload('PUT', sprintf('import/asset/%d', $assetId), $filePath, null, [
            'fileName' => basename($filePath),
        ]);

        return new Asset($result);
    }
}
