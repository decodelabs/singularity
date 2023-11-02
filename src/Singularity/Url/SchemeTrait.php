<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use Closure;
use DecodeLabs\Exceptional;

trait SchemeTrait
{
    protected ?string $scheme;

    public function withScheme(
        string|Closure $scheme
    ): static {
        $output = clone $this;

        if ($scheme instanceof Closure) {
            $scheme = $scheme($this->scheme ?? 'https', $this);
        }

        $output->scheme = static::normalizeScheme($scheme);

        return $output;
    }

    public function getScheme(): string
    {
        return $this->scheme ?? 'https';
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
                'Invalid scheme: ' . $scheme
            );
        }

        return $scheme;
    }
}
