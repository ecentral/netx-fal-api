<?php
namespace Fairway\NetXFalApi\Models;

class View
{
    public int $id;
    public int $assetId;
    public ?string $type = null;
    public ?string $url = null;
    public ?string $createdDate = null;
    public ?string $modifiedDate = null;

    public function __construct(array $data)
    {
        $this->id           = (int) ($data['id'] ?? 0);
        $this->assetId      = (int) ($data['assetId'] ?? 0);
        $this->type         = $data['type'] ?? null;
        $this->url          = $data['url'] ?? null;
        $this->createdDate  = $data['createdDate'] ?? null;
        $this->modifiedDate = $data['modifiedDate'] ?? null;
    }
}
