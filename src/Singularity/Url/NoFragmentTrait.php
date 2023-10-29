<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use DecodeLabs\Exceptional;

trait NoFragmentTrait
{
    public function withFragment(?string $fragment): static
    {
        throw Exceptional::Logic(
            'This URL does not support a fragment'
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

    public static function normalizeFragment(?string $fragment): ?string
    {
        throw Exceptional::Logic(
            'This URL does not support a fragment'
        );
    }
}
