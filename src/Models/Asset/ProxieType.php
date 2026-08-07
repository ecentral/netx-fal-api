<?php

declare(strict_types=1);

/*
 * This file is part of the "netx_fal_api" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Fairway\NetXFalApi\Models\Asset;

enum ProxieType
{
    case PREVIEW;
    case THUMBNAIL;

    case UNDEFINED;

    public static function getFormatByString(string $stringProxyType): ProxieType
    {
        return match($stringProxyType) {
            'Thumbnail' => self::THUMBNAIL,
            'Preview' => self::PREVIEW,
            default => self::UNDEFINED,
        };
    }
}
