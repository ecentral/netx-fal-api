<?php
namespace Fairway\NetXFalApi\Services;

use Fairway\NetXFalApi\Http\JsonRpcClient;
use Fairway\NetXFalApi\Models\Attribute;

class AttributeService
{
    private JsonRpcClient $rpc;

    public function __construct(JsonRpcClient $rpc)
    {
        $this->rpc = $rpc;
    }

    /**
     * Get all available attributes in the system.
     *
     * @param string[] $fields
     * @return Attribute[]
     */
    public function getAttributes(array $fields = ['attribute.base']): array
    {
        $result = $this->rpc->call('getAttributes', [['data' => $fields]]);
        return array_map(fn(array $row) => new Attribute($row), $result);
    }

    /**
     * Get a specific attribute by ID.
     *
     * @param int $id
     * @param string[] $fields
     * @return Attribute
     */
    public function getAttributeById(int $id, array $fields = ['attribute.base']): Attribute
    {
        $result = $this->rpc->call('getAttributeById', [$id, ['data' => $fields]]);
        return new Attribute($result);
    }

    /**
     * Update an attribute definition (e.g., label or values).
     *
     * @param int $id
     * @param array $fields
     * @param string[] $data
     * @return Attribute
     */
    public function updateAttribute(int $id, array $fields, array $data = ['attribute.base']): Attribute
    {
        $result = $this->rpc->call('updateAttribute', [
            array_merge(['id' => $id], $fields),
            ['data' => $data]
        ]);
        return new Attribute($result);
    }

    /**
     * Delete an attribute.
     *
     * @param int $id
     * @return bool
     */
    public function deleteAttribute(int $id): bool
    {
        $this->rpc->call('deleteAttribute', [$id]);
        return true;
    }
}
