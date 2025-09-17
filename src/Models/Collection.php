<?php
namespace Fairway\NetXFalApi\Models;

class Collection
{
    public int $id;
    public ?string $name = null;
    public ?string $description = null;
    public ?array $assets = null;
    public ?array $folders = null;

    public function __construct(array $data)
    {
        $this->id          = (int) ($data['id'] ?? 0);
        $this->name        = $data['name'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->assets      = $data['assets'] ?? null;
        $this->folders     = $data['folders'] ?? null;
    }
}
