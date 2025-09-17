<?php
namespace Fairway\NetXFalApi\Models;

class Attribute
{
    public int $id;
    public ?string $name = null;
    public ?string $label = null;
    public ?string $type = null;
    public ?bool $required = null;
    public ?array $values = null;

    public function __construct(array $data)
    {
        $this->id       = (int) ($data['id'] ?? 0);
        $this->name     = $data['name'] ?? null;
        $this->label    = $data['label'] ?? null;
        $this->type     = $data['type'] ?? null;
        $this->required = isset($data['required']) ? (bool) $data['required'] : null;
        $this->values   = $data['values'] ?? null;
    }
}
