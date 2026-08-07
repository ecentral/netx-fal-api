<?php

declare(strict_types=1);

/*
 * This file is part of the "netx_fal_api" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

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
        $this->id          = (int)($data['id'] ?? 0);
        $this->name        = $data['name'] ?? $data['title'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->assets      = $data['assets'] ?? null;
        $this->folders     = $data['folders'] ?? null;
    }
}
