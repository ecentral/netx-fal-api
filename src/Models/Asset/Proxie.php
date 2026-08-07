<?php

declare(strict_types=1);

/*
 * This file is part of the "netx_fal_api" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Fairway\NetXFalApi\Models\Asset;

class Proxie
{
    private ?string $name = null;
    private ?File $file = null;

    public function __construct(?array $data = null)
    {
        $data ??= [];
        $this->name = $data['name'] ?? null;
        $this->file = new File($data['file'] ?? []);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function getProxieType(): ?ProxieType
    {
        return ProxieType::getFormatByString($this->name);
    }
}
