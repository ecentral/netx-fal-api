<?php

namespace Fairway\NetXFalApi\Models\Asset;

enum ProxieType
{
    case PREVIEW;
    case THUMBNAIL;

    case UNDEFINED;

    public static function getFormatByString(string $stringProxyType): ProxieType
    {
        return match($stringProxyType)
        {
            'THUMB' => self::THUMBNAIL,
            'PREVIEW' => self::PREVIEW,
            default => self::UNDEFINED,
        };
    }
}
