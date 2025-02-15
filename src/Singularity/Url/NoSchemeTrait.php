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
use ReflectionClass;

/**
 * @phpstan-require-implements Url
 */
trait NoSchemeTrait
{
    public string $scheme {
        get => $this->getScheme();
    }

    public function withScheme(
        string|Closure $scheme
    ): static {
        throw Exceptional::Logic(
            message: 'Typed URLs do not support changing schemes'
        );
    }

    public function getScheme(): string
    {
        return strtolower(new ReflectionClass($this)->getShortName());
    }

    public function hasScheme(): bool
    {
        return true;
    }

    public static function normalizeScheme(
        string $scheme
    ): string {
        throw Exceptional::Logic(
            message: 'Typed URLs do not support schemes'
        );
    }
}
