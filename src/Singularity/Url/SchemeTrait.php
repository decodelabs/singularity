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
trait SchemeTrait
{
    protected(set) ?string $scheme {
        get => $this->scheme ?? 'https';
    }

    /**
     * @param string|null|Closure(?string,static):?string $scheme
     */
    public function withScheme(
        string|Closure|null $scheme
    ): static {
        $output = clone $this;

        if ($scheme instanceof Closure) {
            $scheme = $scheme($this->scheme, $this);
        }

        $output->scheme = static::normalizeScheme($scheme);

        return $output;
    }

    public function getScheme(): string
    {
        return $this->scheme ?? 'https';
    }

    public function hasScheme(): bool
    {
        return $this->scheme !== null;
    }

    public static function normalizeScheme(
        ?string $scheme
    ): ?string {
        if ($scheme === null) {
            return null;
        }

        $scheme = strtolower($scheme);

        if (!preg_match('/^[a-z][a-z0-9+.-]*$/', $scheme)) {
            throw Exceptional::InvalidArgument(
                message: 'Invalid scheme: ' . $scheme
            );
        }

        return $scheme;
    }
}
