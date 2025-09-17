<?php
namespace Fairway\NetXFalApi\Models;

class Asset
{
    public int $id;
    public ?string $name = null;
    public ?string $fileName = null;
    public ?array $folders = null;
    public ?array $attributes = null;
    public ?array $file = null;
    public ?array $base = null;

    public function __construct(array $data)
    {
        $this->id        = (int) ($data['id'] ?? 0);
        $this->name      = $data['name'] ?? null;
        $this->fileName  = $data['fileName'] ?? null;
        $this->folders   = $data['folders'] ?? null;
        $this->attributes = $data['attributes'] ?? null;
        $this->file      = $data['file'] ?? null;
        $this->base      = $data['base'] ?? null;
    }
}
