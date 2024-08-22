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
trait PortTrait
{
    protected ?int $port = null;

    public function withPort(
        int|string|Closure|null $port
    ): static {
        if ($port === $this->port) {
            return $this;
        }

        $output = clone $this;

        if ($port instanceof Closure) {
            $port = $port($this->port, $this);
        }

        $output->port = static::normalizePort($port);

        return $output;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function hasPort(): bool
    {
        return $this->port !== null;
    }

    public static function normalizePort(
        int|string|null $port
    ): ?int {
        if ($port === null) {
            return null;
        }

        if (!is_numeric($port)) {
            throw Exceptional::InvalidArgument(
                'Invalid port: ' . $port
            );
        }

        if (is_string($port)) {
            $port = (int)$port;
        }

        if (
            $port < 1 ||
            $port > 65535
        ) {
            throw Exceptional::InvalidArgument(
                'Invalid port: ' . $port
            );
        }

        return $port;
    }
}
