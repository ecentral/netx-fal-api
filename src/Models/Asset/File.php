<?php

declare(strict_types=1);

/*
 * This file is part of the "netx_fal_api" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Fairway\NetXFalApi\Models\Asset;

class File
{
    private ?string $name = null;
    private int $size = 0;
    private ?string $url = null;
    private int $width = 0;
    private int $height = 0;

    public function __construct(array $data = [])
    {
        $this->name = $data['name'] ?? null;
        $this->size = $data['size'] ?? 0;
        $this->url = $data['url'] ?? null;
        $this->width = $data['width'] ?? 0;
        $this->height = $data['height'] ?? 0;
    }

    public function getUrlPath(): ?string
    {
        return $this->url;
    }
    //Url without host
    public function getUrl(): ?string
    {
        return $this->url . '/' . $this->name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }
}
