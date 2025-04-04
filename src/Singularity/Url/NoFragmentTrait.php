<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use Closure;
use DecodeLabs\Exceptional;
use DecodeLabs\Singularity\Url;

/**
 * @phpstan-require-implements Url
 */
trait NoFragmentTrait
{
    public ?string $fragment {
        get => null;
    }

    public function withFragment(
        string|Closure|null $fragment
    ): static {
        throw Exceptional::Logic(
            message: 'This URL does not support a fragment'
        );
    }

    public function getFragment(): string
    {
        return '';
    }

    public function hasFragment(): bool
    {
        return false;
    }

    public function isJustFragment(): bool
    {
        return false;
    }

    public static function normalizeFragment(
        ?string $fragment
    ): ?string {
        throw Exceptional::Logic(
            message: 'This URL does not support a fragment'
        );
    }
}
