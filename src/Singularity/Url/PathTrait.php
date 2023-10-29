<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

trait PathTrait
{
    protected ?string $path = null;

    public function withPath(string $path): static
    {
        $output = clone $this;
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

    public static function normalizePath(?string $path): ?string
    {
        if (
            $path === null ||
            $path === ''
        ) {
            return null;
        }

        $path = (string)preg_replace_callback(
            '#(?:[^' . self::VALID_CHARACTERS . ')(:@&=\+\$,/;%]+|%(?![A-Fa-f0-9]{2}))#u',
            function ($matches) {
                return rawurlencode($matches[0]);
            },
            $path
        );

        return $path;
    }
}
