<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use Closure;
use DecodeLabs\Singularity\Url;

/**
 * @phpstan-require-implements Url
 */
trait FragmentTrait
{
    public protected(set) ?string $fragment = null;

    public function withFragment(
        string|Closure|null $fragment
    ): static {
        if ($fragment === $this->fragment) {
            return $this;
        }

        $output = clone $this;

        if ($fragment instanceof Closure) {
            $fragment = $fragment($this->getFragment(), $this);
        }

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

    public function isJustFragment(): bool
    {
        return $this->hasFragment() &&
            !$this->hasScheme() &&
            !$this->hasUserInfo() &&
            !$this->hasHost() &&
            !$this->hasPort() &&
            !$this->hasPath() &&
            !$this->hasQuery();
    }

    public static function normalizeFragment(
        ?string $fragment
    ): ?string {
        if (
            $fragment === null ||
            $fragment === '' ||
            $fragment === '#'
        ) {
            return null;
        }

        $fragment = ltrim($fragment, '#');

        $fragment = (string)preg_replace_callback(
            '/(?:[^' . self::ValidCharacters . self::Delimiters . '%:@\/\?]+|%(?![A-Fa-f0-9]{2}))/u',
            function ($matches) {
                return rawurlencode($matches[0]);
            },
            $fragment
        );

        return $fragment;
    }
}
