<?php

declare(strict_types=1);

/*
 * This file is part of the "netx_fal_api" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Fairway\NetXFalApi\Models;

class View
{
    public int $id;
    public int $assetId;
    public ?string $type = null;
    public ?string $url = null;
    public ?string $createdDate = null;
    public ?string $modifiedDate = null;

    public function __construct(array $data)
    {
        $this->id           = (int)($data['id'] ?? 0);
        $this->assetId      = (int)($data['assetId'] ?? 0);
        $this->type         = $data['type'] ?? null;
        $this->url          = $data['url'] ?? null;
        $this->createdDate  = $data['createdDate'] ?? null;
        $this->modifiedDate = $data['modifiedDate'] ?? null;
    }
}
