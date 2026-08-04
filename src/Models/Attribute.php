<?php

declare(strict_types=1);

/*
 * This file is part of the "netx_fal_api" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Fairway\NetXFalApi\Models;

class Attribute
{
    public int $id;
    public ?string $name = null;
    public ?string $label = null;
    public ?string $type = null;
    public ?bool $required = null;
    public ?array $values = null;

    public function __construct(array $data)
    {
        $this->id       = (int)($data['id'] ?? 0);
        $this->name     = $data['name'] ?? null;
        $this->label    = $data['label'] ?? null;
        $this->type     = $data['type'] ?? null;
        $this->required = isset($data['required']) ? (bool)$data['required'] : null;
        $this->values   = $data['values'] ?? null;
    }
}
