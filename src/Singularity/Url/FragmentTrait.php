<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

trait FragmentTrait
{
    protected ?string $fragment = null;

    public function withFragment(?string $fragment): static
    {
        if ($fragment === $this->fragment) {
            return $this;
        }

        $output = clone $this;
        $output->fragment = static::normalizeFragment($fragment);

        return $output;
    }

    public function getFragment(): string
    {
        return (string)$this->fragment;
    }

    public function hasFragment(): bool
    {
        return $this->fragment !== null;
    }

    public static function normalizeFragment(?string $fragment): ?string
    {
        if (
            $fragment === null ||
            $fragment === '' ||
            $fragment === '#'
        ) {
            return null;
        }

        $fragment = ltrim($fragment, '#');

        $fragment = (string)preg_replace_callback(
            '/(?:[^' . self::VALID_CHARACTERS . self::DELIMITERS . '%:@\/\?]+|%(?![A-Fa-f0-9]{2}))/u',
            function ($matches) {
                return rawurlencode($matches[0]);
            },
            $fragment
        );

        return $fragment;
    }
}
