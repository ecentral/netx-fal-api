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
     * Creates a new folder.
     *
     * @param string $name
     * @param int|null $parentId
     * @param string[] $fields
     * @return Folder
     */
    public function createFolder(string $name, ?int $parentId = null, array $fields = ['folder.base']): Folder
    {
        $params = [['name' => $name]];
        if ($parentId !== null) {
            $params[0]['parentId'] = $parentId;
        }
        $params[] = ['data' => $fields];

        $result = $this->rpc->call('createFolder', $params);
        return new Folder($result);
    }

    /**
     * Get folder by ID.
     *
     * @param int $id
     * @param string[] $fields
     * @return Folder
     */
    public function getFolderById(int $id, array $fields = ['folder.base']): Folder
    {
        $result = $this->rpc->call('getFolderById', [$id, ['data' => $fields]]);
        return new Folder($result);
    }

    /**
     * Get all root folders.
     *
     * @param string[] $fields
     * @return Folder[]
     */
    public function getRootFolders(array $fields = ['folder.base']): array
    {
        $result = $this->rpc->call('getRootFolders', [['data' => $fields]]);
        return array_map(fn(array $row) => new Folder($row), $result);
    }

    /**
     * Get children of a folder.
     *
     * @param int $id
     * @param string[] $fields
     * @return Folder[]
     */
    public function getChildren(int $id, array $fields = ['folder.base']): array
    {
        $result = $this->rpc->call('getChildren', [$id, ['data' => $fields]]);
        return array_map(fn(array $row) => new Folder($row), $result);
    }

    /**
     * Update folder name or parent.
     *
     * @param int $id
     * @param array $fields
     * @param string[] $data
     * @return Folder
     */
    public function updateFolder(int $id, array $fields, array $data = ['folder.base']): Folder
    {
        $result = $this->rpc->call('updateFolder', [
            array_merge(['id' => $id], $fields),
            ['data' => $data]
        ]);
        return new Folder($result);
    }

    /**
     * Delete a folder by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteFolder(int $id): bool
    {
        $this->rpc->call('deleteFolder', [$id]);
        return true;
    }
}
