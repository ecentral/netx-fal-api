<?php

declare(strict_types=1);

/*
 * This file is part of the "netx_fal_api" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Fairway\NetXFalApi\Models;

class Version
{
    public int $id;
    public int $assetId;
    public ?int $versionNumber = null;
    public ?string $createdDate = null;
    public ?string $modifiedDate = null;
    public ?string $fileName = null;
    public ?string $createdBy = null;

    public function __construct(array $data)
    {
        $this->id            = (int)($data['id'] ?? 0);
        $this->assetId       = (int)($data['assetId'] ?? 0);
        $this->versionNumber = isset($data['versionNumber']) ? (int)$data['versionNumber'] : null;
        $this->createdDate   = $data['createdDate'] ?? null;
        $this->modifiedDate  = $data['modifiedDate'] ?? null;
        $this->fileName      = $data['fileName'] ?? null;
        $this->createdBy     = $data['createdBy'] ?? null;
    }
}
