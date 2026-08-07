<?php

declare(strict_types=1);

/*
 * This file is part of the "netx_fal_api" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Fairway\NetXFalApi\Models\Folder;

class Children
{
    private int $assetCount = 0;

    private int $folderCount = 0;

    public function __construct(array $data = [])
    {
        $this->assetCount = $data['assetCount'] ?? 0;
        $this->folderCount = $data['folderCount'] ?? 0;
    }

    public function getAssetCount(): int
    {
        return $this->assetCount;
    }

    public function getFolderCount(): int
    {
        return $this->folderCount;
    }

    public function hasAssets(): bool
    {
        return $this->assetCount > 0;
    }
    public function hasChildFolder(): bool
    {
        return $this->folderCount > 0;
    }
}
