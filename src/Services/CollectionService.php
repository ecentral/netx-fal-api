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
    public function __construct(private readonly JsonRpcClient $rpc)
    {
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
        $result = $this->rpc->call('getCollection', [$id, ['data' => $fields]]);
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
    public function updateCollection(int $id, array $fields, array $assetIds, array $data = ['collection.base']): Collection
    {
        $result = $this->rpc->call('updateCollection', [
            array_merge(['id' => $id], $fields),
            array_values(array_map(intval(...), $assetIds)),
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
     * NetX has no add method, so the full asset list is saved again.
     *
     * @param int $collectionId
     * @param int $assetId
     * @param string[] $fields
     * @return Collection
     */
    public function addAssetToCollection(int $collectionId, int $assetId, array $fields = ['collection.base']): Collection
    {
        $collection = $this->getCollectionById($collectionId);
        $ids = $this->getAssetIdsByCollection($collectionId);

        if (!in_array($assetId, $ids, true)) {
            $ids[] = $assetId;
        }

        return $this->updateCollection($collectionId, ['title' => $collection->name], $ids, $fields);
    }

    /**
     * Remove an asset from a collection.
     * NetX has no remove method, so the remaining asset list is saved again.
     *
     * @param int $collectionId
     * @param int $assetId
     * @param string[] $fields
     * @return Collection
     */
    public function removeAssetFromCollection(int $collectionId, int $assetId, array $fields = ['collection.base']): Collection
    {
        $collection = $this->getCollectionById($collectionId);
        $ids = array_values(array_filter(
            $this->getAssetIdsByCollection($collectionId),
            fn (int $id) => $id !== $assetId,
        ));

        return $this->updateCollection($collectionId, ['title' => $collection->name], $ids, $fields);
    }

    /**
     * @return int[]
     */
    public function getAssetIdsByCollection(int $id): array
    {
        $result = $this->rpc->call('getAssetsByCollection', [$id, ['data' => ['asset.id']]]);
        return array_map(fn (array $row) => (int)$row['id'], $result['results'] ?? []);
    }
}
