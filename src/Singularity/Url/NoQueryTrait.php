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
use DecodeLabs\Exceptional;

trait NoQueryTrait
{
    public function withQuery(
        string|array|Tree|Closure|null $query
    ): static {
        throw Exceptional::Logic(
            'This URL does not support a query'
        );
    }

    public function getQuery(): string
    {
        return '';
    }

    public function hasQuery(): bool
    {
        return false;
    }

    public function parseQuery(): Tree
    {
        return new MutableTree();
    }

    public static function normalizeQuery(
        string|array|Tree|null $query
    ): ?string {
        throw Exceptional::Logic(
            'This URL does not support a query'
        );
    }
}
