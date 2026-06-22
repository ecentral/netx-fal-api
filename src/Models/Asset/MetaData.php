<?php

namespace Fairway\NetXFalApi\Models\Asset;

class MetaData
{
    private array $metaData = [];
    public function __construct(array $metaData = [])
    {
        $this->metaData = $metaData;
    }

    public function getMetaData($metaDataKey)
    {
        return $this->metaData[$metaDataKey] ?? null;
    }
}
