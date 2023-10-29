<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use DecodeLabs\Collections\Tree;
use DecodeLabs\Collections\Tree\NativeMutable as MutableTree;

trait QueryTrait
{
    protected ?string $query = null;

    public function withQuery(?string $query): static
    {
        if ($query === $this->query) {
            return $this;
        }

        $output = clone $this;
        $output->query = static::normalizeQuery($query);

        return $output;
    }

    public function getQuery(): string
    {
        return (string)$this->query;
    }

    public function hasQuery(): bool
    {
        return $this->query !== null;
    }

    public static function normalizeQuery(?string $query): ?string
    {
        if (
            $query === null ||
            $query === '' ||
            $query === '?'
        ) {
            return null;
        }

        $query = ltrim($query, '?');
        $parts = explode('&', $query);

        foreach ($parts as $i => $part) {
            [$key, $value] = explode('=', (string)$part, 2);
            $value = static::normalizeQueryFragment($value);

            if ($value === null) {
                $parts[$i] = static::normalizeQueryFragment($key);
            } else {
                $parts[$i] = static::normalizeQueryFragment($key) . '=' . $value;
            }
        }

        return implode('&', $parts);
    }

    protected static function normalizeQueryFragment(?string $fragment): ?string
    {
        if (
            $fragment === null ||
            $fragment === ''
        ) {
            return null;
        }

        $fragment = (string)preg_replace_callback(
            '/(?:[^' . self::VALID_CHARACTERS . self::DELIMITERS . '%:@\/\?]+|%(?![A-Fa-f0-9]{2}))/u',
            function ($matches) {
                return rawurlencode($matches[0]);
            },
            $fragment
        );

        return $fragment;
    }

    public function withQueryTree(?Tree $query): static
    {
        if ($query !== null) {
            $query = $query->toDelimitedString();
        }

        return $this->withQuery($query);
    }

    public function getQueryTree(): Tree
    {
        /** @var Tree<int|float|string|null> */
        $output = MutableTree::fromDelimitedString($this->query ?? '');
        return $output;
    }
}
