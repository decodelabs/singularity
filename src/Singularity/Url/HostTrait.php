<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use DecodeLabs\Exceptional;

trait HostTrait
{
    protected ?string $host = null;

    public function withHost(?string $host): static
    {
        if ($host === $this->host) {
            return $this;
        }

        $output = clone $this;
        $output->host = static::normalizeHost($host);

        return $output;
    }

    public function getHost(): string
    {
        return (string)$this->host;
    }

    public function hasHost(): bool
    {
        return $this->host !== null;
    }

    public static function normalizeHost(?string $host): ?string
    {
        if ($host === null) {
            return null;
        }

        $host = strtolower($host);

        if (filter_var($host, FILTER_VALIDATE_IP)) {
            return $host;
        }

        if (!$host = idn_to_ascii($host, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46)) {
            throw Exceptional::InvalidArgument(
                'Invalid host: ' . $host
            );
        }

        if (preg_match('/[^a-z0-9\.\-]/', $host)) {
            throw Exceptional::InvalidArgument(
                'Invalid host: ' . $host
            );
        }

        return $host;
    }
}
