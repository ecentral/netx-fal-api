<?php


namespace Fairway\NetXFalApi\Models\Folder;

class Children
{
    private int $assetCount = 0;

    private int $folderCount = 0;

    public function __construct(array $data)
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
