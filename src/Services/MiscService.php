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
use Fairway\NetXFalApi\Models\Location;

class MiscService
{
    private JsonRpcClient $rpc;

    public function __construct(JsonRpcClient $rpc)
    {
        $this->rpc = $rpc;
    }

    /**
     * Get the API version.
     *
     * @return string
     */
    public function getVersion(): string
    {
        $result = $this->rpc->call('getVersion', []);
        return (string)($result['version'] ?? '');
    }

    /**
     * Authenticate a user by username and password.
     *
     * @param string $username
     * @param string $password
     * @return string API token
     */
    public function authenticate(string $username, string $password): string
    {
        $result = $this->rpc->call('authenticate', [$username, $password]);
        return $result['apiToken'] ?? '';
    }

    /**
     * Get available storage locations.
     *
     * @return Location[]
     */
    public function getLocations(): array
    {
        $result = $this->rpc->call('getLocations', []);
        return array_map(fn (array $row) => new Location($row), $result);
    }
}
