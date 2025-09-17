<?php
namespace Fairway\NetXFalApi\Models;

class Folder
{
    public int $id;
    public ?string $name = null;
    public ?int $parentId = null;
    public ?array $children = null;
    public ?array $assets = null;

    public function __construct(array $data)
    {
        $this->id       = (int) ($data['id'] ?? 0);
        $this->name     = $data['name'] ?? null;
        $this->parentId = isset($data['parentId']) ? (int) $data['parentId'] : null;
        $this->children = $data['children'] ?? null;
        $this->assets   = $data['assets'] ?? null;
    }
}
