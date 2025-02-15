<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use Closure;
use DecodeLabs\Exceptional;
use DecodeLabs\Singularity\Path;
use DecodeLabs\Singularity\Url;

/**
 * @phpstan-require-implements Url
 */
trait NoPathTrait
{
    public ?string $path {
        get => null;
    }

    public function withPath(
        string|Path|Closure|null $path
    ): static {
        throw Exceptional::Logic(
            message: 'This URL does not support a path'
        );
    }

    public function getPath(): string
    {
        return '';
    }

    public function parsePath(): ?Path
    {
        return null;
    }

    public function hasPath(): bool
    {
        return false;
    }

    public static function normalizePath(
        string|Path|null $path
    ): ?string {
        throw Exceptional::Logic(
            message: 'This URL does not support a path'
        );
    }
}
