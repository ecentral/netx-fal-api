<?php

namespace Fairway\NetXFalApi\Models\Asset;

class Proxie
{
    private ?string $name = null;
    private ?File $file = null;

    public function __construct(?array $data = null)
    {
        $data ??= [];
        $this->name = $data['name'] ?? null;
        $this->file = new File($data['file'] ?? []);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function getProxieType(): ?ProxieType
    {
        return ProxieType::getFormatByString($this->name);
    }
}
