<?php

declare(strict_types=1);

/*
 * This file is part of the "netx_fal_api" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Fairway\NetXFalApi\Models;

class Location
{
    public int $id;
    public ?string $name = null;
    public ?string $type = null;
    public ?string $path = null;

    public function __construct(array $data)
    {
        $this->id   = (int)($data['id'] ?? 0);
        $this->name = $data['name'] ?? null;
        $this->type = $data['type'] ?? null;
        $this->path = $data['path'] ?? null;
    }
}
