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
use Fairway\NetXFalApi\Models\Collection;

class CollectionService
{
    private JsonRpcClient $rpc;

    public function __construct(JsonRpcClient $rpc)
    {
        $this->rpc = $rpc;
    }

    /**
     * Creates a new collection.
     *
     * @param string $name
     * @param string|null $description
     * @param string[] $fields
     * @return Collection
     */
    public function createCollection(string $name, ?string $description = null, array $fields = ['collection.base']): Collection
    {
        $params = [['title' => $name]];
        if ($description !== null) {
            $params[0]['description'] = $description;
        }
        $params[] = [];
        $params[] = ['data' => $fields];

        $result = $this->rpc->call('createCollection', $params);
        return new Collection($result);
    }

    /**
     * Get a collection by ID.
     *
     * @param int $id
     * @param string[] $fields
     * @return Collection
     */
    public function getCollectionById(int $id, array $fields = ['collection.base']): Collection
    {
        $result = $this->rpc->call('getCollectionById', [$id, ['data' => $fields]]);
        return new Collection($result);
    }

    /**
     * Get all collections for the current user.
     *
     * @param string[] $fields
     * @return Collection[]
     */
    public function getCollections(array $fields = ['collection.base']): array
    {
        $result = $this->rpc->call('getCollections', [['data' => $fields]]);
        return array_map(fn (array $row) => new Collection($row), $result['results'] ?? $result);
    }

    /**
     * Update a collection.
     *
     * @param int $id
     * @param array $fields
     * @param string[] $data
     * @return Collection
     */
    public function updateCollection(int $id, array $fields, array $data = ['collection.base']): Collection
    {
        $result = $this->rpc->call('updateCollection', [
            array_merge(['id' => $id], $fields),
            ['data' => $data]
        ]);
        return new Collection($result);
    }

    /**
     * Delete a collection by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteCollection(int $id): bool
    {
        $this->rpc->call('deleteCollection', [$id]);
        return true;
    }

    /**
     * Add an asset to a collection.
     *
     * @param int $collectionId
     * @param int $assetId
     * @param string[] $fields
     * @return Collection
     */
    public function addAssetToCollection(int $collectionId, int $assetId, array $fields = ['collection.base']): Collection
    {
        $result = $this->rpc->call('addAssetToCollection', [
            $collectionId,
            $assetId,
            ['data' => $fields]
        ]);
        return new Collection($result);
    }

    /**
     * Remove an asset from a collection.
     *
     * @param int $collectionId
     * @param int $assetId
     * @param string[] $fields
     * @return Collection
     */
    public function removeAssetFromCollection(int $collectionId, int $assetId, array $fields = ['collection.base']): Collection
    {
        $result = $this->rpc->call('removeAssetFromCollection', [
            $collectionId,
            $assetId,
            ['data' => $fields]
        ]);
        return new Collection($result);
    }
}
