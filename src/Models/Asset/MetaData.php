<?php

declare(strict_types=1);

/*
 * This file is part of the "netx_fal_api" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Fairway\NetXFalApi\Models\Asset;

class MetaData
{
    private array $metaData = [];

    public function __construct(array $metaData = [])
    {
        $this->metaData = $metaData;
    }

    public function getMetaData(string $metaDataKey): mixed
    {
        return $this->metaData[$metaDataKey] ?? null;
    }
}
