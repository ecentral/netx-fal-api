<?php
namespace Fairway\NetXFalApi\Models;

class Version
{
    public int $id;
    public int $assetId;
    public ?int $versionNumber = null;
    public ?string $createdDate = null;
    public ?string $modifiedDate = null;
    public ?string $fileName = null;
    public ?string $createdBy = null;

    public function __construct(array $data)
    {
        $this->id            = (int) ($data['id'] ?? 0);
        $this->assetId       = (int) ($data['assetId'] ?? 0);
        $this->versionNumber = isset($data['versionNumber']) ? (int) $data['versionNumber'] : null;
        $this->createdDate   = $data['createdDate'] ?? null;
        $this->modifiedDate  = $data['modifiedDate'] ?? null;
        $this->fileName      = $data['fileName'] ?? null;
        $this->createdBy     = $data['createdBy'] ?? null;
    }
}
