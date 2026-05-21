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
        return array_map(fn(array $row) => new Attribute($row), $this->attributeRows($result));
    }

    /**
     * @param array<mixed> $result
     * @return array<int, array<mixed>>
     */
    private function attributeRows(array $result): array
    {
        foreach (['results', 'items', 'data'] as $key) {
            if (isset($result[$key]) && is_array($result[$key])) {
                $result = $result[$key];
                break;
            }
        }

        if (array_key_exists('id', $result) || array_key_exists('name', $result)) {
            return [$result];
        }

        return array_values(array_filter(
            $result,
            static fn (mixed $row): bool => is_array($row) && (array_key_exists('id', $row) || array_key_exists('name', $row)),
        ));
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
     * Get configured values for a specific attribute.
     *
     * @param int $attributeId
     * @param string[] $fields
     * @return array<int, array<mixed>>
     */
    public function getValuesByAttribute(int $attributeId, array $fields = ['attributeValue.base']): array
    {
        $result = $this->rpc->call('getValuesByAttribute', [$attributeId, ['data' => $fields]]);

        return $this->valueRows($result);
    }

    /**
     * @param array<mixed> $result
     * @return array<int, array<mixed>>
     */
    private function valueRows(array $result): array
    {
        foreach (['results', 'items', 'data', 'values'] as $key) {
            if (isset($result[$key]) && is_array($result[$key])) {
                $result = $result[$key];
                break;
            }
        }

        if (array_key_exists('id', $result) || array_key_exists('name', $result) || array_key_exists('value', $result)) {
            return [$result];
        }

        return array_values(array_filter(
            $result,
            static fn (mixed $row): bool => is_array($row) && (array_key_exists('id', $row) || array_key_exists('name', $row) || array_key_exists('value', $row)),
        ));
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
