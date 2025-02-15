<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use Closure;
use DecodeLabs\Singularity\Path;
use DecodeLabs\Singularity\Url;

/**
 * @phpstan-require-implements Url
 */
trait PathTrait
{
    protected(set) ?string $path = null;

    /**
     * @param string|Path|Closure(?Path,static):(string|Path|null)|null $path
     */
    public function withPath(
        string|Path|Closure|null $path
    ): static {
        $output = clone $this;

        if ($path instanceof Closure) {
            $path = $path($this->parsePath(), $this);
        }

        $output->path = static::normalizePath($path);

        return $output;
    }

    public function getPath(): string
    {
        return (string)$this->path;
    }

    public function hasPath(): bool
    {
        return $this->path !== null;
    }

    public function parsePath(): ?Path
    {
        if ($this->path === null) {
            return null;
        }

        return Path::fromString($this->path);
    }

    public static function normalizePath(
        string|Path|null $path
    ): ?string {
        if (
            $path === null ||
            $path === ''
        ) {
            return null;
        }

        if ($path instanceof Path) {
            $path = $path->__toString();
        }

        $path = (string)preg_replace_callback(
            '#(?:[^' . self::ValidCharacters . ')(:@&=\+\$,/;%]+|%(?![A-Fa-f0-9]{2}))#u',
            function ($matches) {
                return rawurlencode($matches[0]);
            },
            $path
        );

        $path = '/' . ltrim($path, '/');

        return $path;
    }
}
