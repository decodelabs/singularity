<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use Closure;
use DecodeLabs\Exceptional;
use DecodeLabs\Singularity\Url;

/**
 * @phpstan-require-implements Url
 */
trait NoSchemeTrait
{
    public function withScheme(
        string|Closure $scheme
    ): static {
        throw Exceptional::Logic(
            'Typed URLs do not support changing schemes'
        );
    }

    public function hasScheme(): bool
    {
        return true;
    }

    public function getScheme(): string
    {
        return strtolower((new ReflectionClass($this))->getShortName());
    }

    public static function normalizeScheme(
        string $scheme
    ): string {
        throw Exceptional::Logic(
            'Typed URLs do not support schemes'
        );
    }
}
