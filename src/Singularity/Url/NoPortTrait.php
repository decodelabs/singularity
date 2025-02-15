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
trait NoPortTrait
{
    public ?int $port {
        get => null;
    }

    public function withPort(
        int|string|Closure|null $port
    ): static {
        throw Exceptional::Logic(
            message: 'This URL does not support a port'
        );
    }

    public function getPort(): ?int
    {
        return null;
    }

    public function hasPort(): bool
    {
        return false;
    }

    public static function normalizePort(
        int|string|null $port
    ): ?int {
        throw Exceptional::Logic(
            message: 'This URL does not support a port'
        );
    }
}
