<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use DecodeLabs\Exceptional;

trait NoPathTrait
{
    public function withPath(string $path): static
    {
        throw Exceptional::Logic(
            'This URL does not support a path'
        );
    }

    public function getPath(): string
    {
        return '';
    }

    public function hasPath(): bool
    {
        return false;
    }

    public static function normalizePath(?string $path): ?string
    {
        throw Exceptional::Logic(
            'This URL does not support a path'
        );
    }
}
