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
use DecodeLabs\Singularity\Url;

/**
 * @phpstan-require-implements Url
 */
trait HostTrait
{
    protected ?string $host = null;

    public function withHost(
        string|Ip|Closure|null $host
    ): static {
        if ($host === $this->host) {
            return $this;
        }

        $output = clone $this;

        if ($host instanceof Closure) {
            $host = $host($this->parseIp() ?? $this->host, $this);
        }

        $output->host = static::normalizeHost($host);

        return $output;
    }

    public function getHost(): string
    {
        return (string)$this->host;
    }

    public function parseIp(): ?Ip
    {
        if (
            $this->host === null ||
            !Ip::isValid($this->host)
        ) {
            return null;
        }

        return Ip::parse($this->host);
    }

    public function hasHost(): bool
    {
        return $this->host !== null;
    }

    public static function normalizeHost(
        string|Ip|null $host
    ): ?string {
        if ($host === null) {
            return null;
        }

        $host = strtolower((string)$host);

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
