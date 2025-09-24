<?php
namespace Fairway\NetXFalApi\Models;

use Fairway\NetXFalApi\Models\Folder\Children;

class Folder
{
    private int $id;
    private ?string $name = null;
    private ?int $parentId = null;
    protected ?Children $children = null;
    protected ?array $assets = null;

    public function __construct(array $data)
    {
        $this->id       = (int) ($data['id'] ?? 0);
        $this->name     = $data['name'] ?? null;
        $this->parentId = isset($data['parentId']) ? (int) $data['parentId'] : null;
        $this->children = new Children($data['children'] ?? null);
        $this->assets   = $data['assets'] ?? null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function hasAssets(): bool
    {
        return $this->children->hasAssets();
    }

    public function hasChildFolder(): bool
    {
        return $this->children->hasChildFolder();
    }
}
