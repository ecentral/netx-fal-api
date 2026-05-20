<?php
namespace Fairway\NetXFalApi\Services;

use Fairway\NetXFalApi\Http\JsonRpcClient;
use Fairway\NetXFalApi\Models\Folder;

class FolderService
{
    private JsonRpcClient $rpc;

    public function __construct(JsonRpcClient $rpc)
    {
        $this->rpc = $rpc;
    }

    /**
     * Create a new folder.
     * Mirrors NetX JSON-RPC: createFolder(paramsObject, { data: [...] })
     *
     * @param string      $name
     * @param int|null    $parentId
     * @param string|null $description
     * @return Folder
     */
    public function createFolder(string $name, ?int $parentId = null, ?string $description = null): Folder
    {
        $payload = [
            'name' => $name,
            'description' => $description ?? '',
        ];
        if ($parentId !== null)    $payload['parentId'] = $parentId;

        $result = $this->rpc->call('createFolder', [$payload, $this->folderDataOptions()]);
        return new Folder($result);
    }

    /**
     * Update an existing folder.
     * Mirrors NetX JSON-RPC: updateFolder(paramsObject, { data: [...] })
     *
     * @param int         $id
     * @param int|null    $parentId
     * @param string|null $name
     * @param string|null $description
     * @return Folder
     */
    public function updateFolder(int $id, ?int $parentId = null, ?string $name = null, ?string $description = null): Folder
    {
        $payload = ['id' => $id];
        if ($parentId !== null)    $payload['parentId'] = $parentId;
        if ($name !== null)        $payload['name'] = $name;
        if ($description !== null) $payload['description'] = $description;

        $result = $this->rpc->call('updateFolder', [$payload, $this->folderDataOptions()]);
        return new Folder($result);
    }

    /**
     * Find a folder with a given ID.
     * Mirrors Postman: getFolderById(id, { data: [...] })
     *
     * @param int        $id
     * @param string[]   $fields e.g. ["folder.id","folder.base","folder.children"]
     * @return Folder
     */
    public function getFolderById(int $id, array $fields = ['folder.id','folder.base','folder.children']): Folder
    {
        $result = $this->rpc->call('getFolderById', [$id, ['data' => $fields]]);
        return new Folder($result);
    }

    /**
     * Lists the folders with a given folder as parent.
     * Mirrors Postman: getFoldersByParent(parentId, { page: {startIndex,size}, data: [...] })
     *
     * @param int      $parentId
     * @param int      $startIndex
     * @param int      $size
     * @param string[] $fields   e.g. ["folder.id","folder.base"]
     * @return Folder[]
     */
    public function getFoldersByParent(
        int $parentId,
        int $startIndex = 0,
        int $size = 10,
        array $fields = ['folder.id','folder.base','folder.children']
    ): array {
        $result = $this->rpc->call('getFoldersByParent', [
            $parentId,
            [
                'page' => ['startIndex' => $startIndex, 'size' => $size],
                'data' => $fields
            ]
        ]);

        return array_map(fn(array $row) => new Folder($row), $result['results'] ?? []);
    }

    /**
     * Lists folders whose names contain a filter string.
     * Mirrors Postman: getFoldersByNameFilter(filter, { page, data })
     *
     * @param string   $filter
     * @param int      $startIndex
     * @param int      $size
     * @param string[] $fields
     * @return Folder[]
     */
    public function getFoldersByNameFilter(
        string $filter,
        int $startIndex = 0,
        int $size = 10,
        array $fields = ['folder.id','folder.base']
    ): array {
        $result = $this->rpc->call('getFoldersByNameFilter', [
            $filter,
            [
                'page' => ['startIndex' => $startIndex, 'size' => $size],
                'data' => $fields
            ]
        ]);

        return array_map(fn(array $row) => new Folder($row), $result);
    }

    /**
     * Finds a folder with a given path.
     * Mirrors Postman: getFolderByPath(path, { data: [...] })
     *
     * @param string   $path
     * @param string[] $fields
     * @return Folder
     */
    public function getFolderByPath(string $path, array $fields = ['folder.id','folder.base','folder.children']): Folder
    {
        $result = $this->rpc->call('getFolderByPath', [
            $path,
            ['data' => $fields]
        ]);
        return new Folder($result);
    }

    /**
     * Creates a new folder (and ancestors) based on a path.
     * Mirrors Postman: createFolderFromPath(path, { data: [...] })
     *
     * @param string   $path  e.g. "Portraits/Color/Pets"
     * @param string[] $fields
     * @return Folder
     */
    public function createFolderFromPath(string $path, array $fields = ['folder.id','folder.base','folder.children']): Folder
    {
        $result = $this->rpc->call('createFolderFromPath', [
            $path,
            ['data' => $fields]
        ]);
        return new Folder($result);
    }

    /**
     * Delete an existing folder by its ID.
     * Mirrors Postman: deleteFolder(id, null)
     *
     * @param int $id
     * @return bool
     */
    public function deleteFolder(int $id): bool
    {
        $this->rpc->call('deleteFolder', [$id, null]);
        return true;
    }

    /**
     * @return array{data: string[]}
     */
    private function folderDataOptions(): array
    {
        return [
            'data' => ['folder.id','folder.base','folder.children'],
        ];
    }
}
