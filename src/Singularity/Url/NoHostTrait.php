<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use Closure;
use DecodeLabs\Compass\Ip;
use DecodeLabs\Exceptional;

trait NoHostTrait
{
    public function withHost(
        string|Ip|Closure|null $host
    ): static {
        throw Exceptional::Logic(
            'This URL does not support a host'
        );
    }

    public function getHost(): string
    {
        return '';
    }

    public function parseIp(): ?Ip
    {
        return null;
    }

    public function hasHost(): bool
    {
        return false;
    }

    public static function normalizeHost(
        string|Ip|null $host
    ): ?string {
        throw Exceptional::Logic(
            'This URL does not support a host'
        );
    }
}
