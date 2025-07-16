<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use Closure;
use DecodeLabs\Collections\Tree;
use DecodeLabs\Singularity\Url;

/**
 * @phpstan-require-implements Url
 * @phpstan-type Query = string|array<int|float|string|null>|Tree<int|float|string|null>
 */
trait QueryTrait
{
    public protected(set) ?string $query = null;

    public function withQuery(
        string|array|Tree|Closure|null $query
    ): static {
        if ($query === $this->query) {
            return $this;
        }

        $output = clone $this;

        if ($query instanceof Closure) {
            $query = $query($this->parseQuery(), $this);
        }

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

    public function parseQuery(): Tree
    {
        /**
         * @var Tree<int|float|bool|string>
         * @phpstan-ignore-next-line
         */
        $output = Tree::fromDelimitedString($this->query ?? '');
        return $output;
    }

    public static function normalizeQuery(
        string|array|Tree|null $query
    ): ?string {
        if (
            $query === null ||
            $query === '' ||
            $query === '?' ||
            $query === []
        ) {
            return null;
        }

        if (is_array($query)) {
            // @phpstan-ignore-next-line
            $query = new Tree($query);
        } elseif (is_string($query)) {
            $query = Tree::fromDelimitedString($query);
        }

        return $query->toDelimitedString();
    }
}
