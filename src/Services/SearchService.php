<?php

declare(strict_types=1);

/*
 * This file is part of the "netx_fal_api" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Fairway\NetXFalApi\Services;

use Fairway\NetXFalApi\Http\JsonRpcClient;
use Fairway\NetXFalApi\Models\Asset;
use Fairway\NetXFalApi\Models\Collection;

class SearchService
{
    public function __construct(private readonly JsonRpcClient $rpc)
    {
    }

    /**
     * Search for assets by keyword.
     *
     * @param string $query
     * @param int $startIndex
     * @param int $size
     * @param string[] $fields
     * @return Asset[]
     */
    public function searchAssets(
        string $query,
        int $startIndex = 0,
        int $size = 10,
        array $fields = ['asset.base']
    ): array {
        $result = $this->rpc->call('searchAssets', [
            $query,
            [
                'page' => ['startIndex' => $startIndex, 'size' => $size],
                'data' => $fields
            ]
        ]);
        return array_map(fn (array $row) => new Asset($row), $result);
    }

    /**
     * Search for collections by keyword.
     *
     * @param string $query
     * @param int $startIndex
     * @param int $size
     * @param string[] $fields
     * @return Collection[]
     */
    public function searchCollections(
        string $query,
        int $startIndex = 0,
        int $size = 10,
        array $fields = ['collection.base']
    ): array {
        $result = $this->rpc->call('searchCollections', [
            $query,
            [
                'page' => ['startIndex' => $startIndex, 'size' => $size],
                'data' => $fields
            ]
        ]);
        return array_map(fn (array $row) => new Collection($row), $result);
    }
}
