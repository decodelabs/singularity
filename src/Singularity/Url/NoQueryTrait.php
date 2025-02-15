<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use Closure;
use DecodeLabs\Collections\Tree;
use DecodeLabs\Exceptional;
use DecodeLabs\Singularity\Url;

/**
 * @phpstan-require-implements Url
 */
trait NoQueryTrait
{
    public ?string $query {
        get => null;
    }

    public function withQuery(
        string|array|Tree|Closure|null $query
    ): static {
        throw Exceptional::Logic(
            message: 'This URL does not support a query'
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
        /** @var Tree<float|int|string|null> $output */
        $output = new Tree();
        return $output;
    }

    public static function normalizeQuery(
        string|array|Tree|null $query
    ): ?string {
        throw Exceptional::Logic(
            message: 'This URL does not support a query'
        );
    }
}
