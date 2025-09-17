<?php
namespace Fairway\NetXFalApi\Services;

use Fairway\NetXFalApi\Http\JsonRpcClient;
use Fairway\NetXFalApi\Models\View;

class ViewService
{
    private JsonRpcClient $rpc;

    public function __construct(JsonRpcClient $rpc)
    {
        $this->rpc = $rpc;
    }

    /**
     * Get all views for a specific asset.
     *
     * @param int $assetId
     * @param string[] $fields
     * @return View[]
     */
    public function getViewsByAsset(int $assetId, array $fields = ['view.base']): array
    {
        $result = $this->rpc->call('getViewsByAsset', [$assetId, ['data' => $fields]]);
        return array_map(fn(array $row) => new View($row), $result);
    }

    /**
     * Get a single view by ID.
     *
     * @param int $viewId
     * @param string[] $fields
     * @return View
     */
    public function getViewById(int $viewId, array $fields = ['view.base']): View
    {
        $result = $this->rpc->call('getViewById', [$viewId, ['data' => $fields]]);
        return new View($result);
    }

    /**
     * Delete a view.
     *
     * @param int $viewId
     * @return bool
     */
    public function deleteView(int $viewId): bool
    {
        $this->rpc->call('deleteView', [$viewId]);
        return true;
    }
}
