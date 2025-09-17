<?php
namespace Fairway\NetXFalApi\Models;

class Location
{
    public int $id;
    public ?string $name = null;
    public ?string $type = null;
    public ?string $path = null;

    public function __construct(array $data)
    {
        $this->id   = (int) ($data['id'] ?? 0);
        $this->name = $data['name'] ?? null;
        $this->type = $data['type'] ?? null;
        $this->path = $data['path'] ?? null;
    }
}
