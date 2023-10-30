<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use Closure;
use DecodeLabs\Collections\Tree;
use DecodeLabs\Collections\Tree\NativeMutable as MutableTree;

trait QueryTrait
{
    protected ?string $query = null;

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
        /** @var Tree<int|float|string|null> */
        $output = MutableTree::fromDelimitedString($this->query ?? '');
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
            $query = new MutableTree($query);
        } elseif (is_string($query)) {
            $query = MutableTree::fromDelimitedString($query);
        }

        return $query->toDelimitedString();
    }
}
