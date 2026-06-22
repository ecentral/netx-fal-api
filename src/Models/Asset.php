<?php
namespace Fairway\NetXFalApi\Models;

use Fairway\NetXFalApi\Models\Asset\File;
use Fairway\NetXFalApi\Models\Asset\MetaData;
use Fairway\NetXFalApi\Models\Asset\Proxie;
use Fairway\NetXFalApi\Models\Asset\ProxieType;

class Asset
{
    private int $id;
    private ?string $name = null;
    private ?string $fileName = null;
    private ?array $containers = null;
    private ?array $attributes = null;
    private ?File $file = null;
    private ?array $proxies = null;
    private int $creationDate = 0;
    private int $modificationDate = 0;

    private MetaData $metaData;
    private int $importDate = 0;

    public function __construct(array $data)
    {
        $this->id        = (int) ($data['id'] ?? 0);
        $this->name      = $data['name'] ?? null;
        $this->fileName  = $data['fileName'] ?? null;
        $this->containers = $data['containers'] ?? $data['folders'] ?? null;
        $this->attributes = $data['attributes'] ?? null;
        $this->file      = new File($data['file'] ?? []);
        $this->proxies = array_map(fn(array $row) => new Proxie($row), $data['proxies'] ?? []);
        $this->creationDate = (int) ($data['creationDate'] ?? 0);
        $this->modificationDate = (int) ($data['modDate'] ?? 0);
        $this->importDate = (int) ($data['importDate'] ?? 0);
        $this->metaData = new MetaData($data['metadata'] ?? []);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function getFolders(): ?array
    {
        return $this->containers;
    }

    public function getContainers(): ?array
    {
        return $this->containers;
    }

    public function getMetaData(): MetaData
    {
        return $this->metaData;
    }

    public function getAttributes(): ?array
    {
        return $this->attributes;
    }

    public function getCreationDate(): int
    {
        return $this->creationDate;
    }

    public function getModificationDate(): int
    {
        return $this->modificationDate;
    }

    public function getImportDate(): int
    {
        return $this->importDate;
    }

    public function getThumbnailUrl(string $host): ?string
    {
        foreach ($this->proxies as $proxie) {
            if($proxie->getProxieType() == ProxieType::THUMBNAIL)
            {
                $urlPath = $host . $this->file->getUrlPath();
                return $urlPath .'/'.$proxie->getFile()->getName();
            }
        }
        return null;
    }
    public function getPreviewUrl(string $host): ?string
    {
        foreach ($this->proxies as $proxie) {
            if($proxie->getProxieType() == ProxieType::PREVIEW)
            {
                $urlPath = $host . $this->file->getUrlPath();
                return $urlPath .'/'.$proxie->getFile()->getName();
            }
        }
        return null;
    }

    public function getOriginalUrl(string $host): ?string
    {
        return $host . $this->file->getUrl();
    }

    public function getSize(): ?int
    {
        return $this->file->getSize();
    }

    public function getWidth(): ?int
    {
        return $this->file->getWidth();
    }
    public function getHeight(): ?int
    {
        return $this->file->getHeight();
    }

    public function getExtension(): string
    {
        return pathinfo($this->fileName, PATHINFO_EXTENSION);
    }
}
