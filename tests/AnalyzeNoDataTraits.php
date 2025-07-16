<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Tests;

use DecodeLabs\Singularity\Url;
use DecodeLabs\Singularity\Url\AuthorityTrait;
use DecodeLabs\Singularity\Url\NoFragmentTrait;
use DecodeLabs\Singularity\Url\NoHostTrait;
use DecodeLabs\Singularity\Url\NoPathTrait;
use DecodeLabs\Singularity\Url\NoPortTrait;
use DecodeLabs\Singularity\Url\NoQueryTrait;
use DecodeLabs\Singularity\Url\NoSchemeTrait;
use DecodeLabs\Singularity\Url\NoUserInfoTrait;

class AnalyzeNoDataTraits implements Url
{
    use NoSchemeTrait;
    use NoUserInfoTrait;
    use NoHostTrait;
    use NoPortTrait;
    use NoPathTrait;
    use NoQueryTrait;
    use NoFragmentTrait;
    use AuthorityTrait;

    public static function fromString(
        string $uri
    ): static {
        return new static();
    }

    final public function __construct()
    {
    }

    public function __toString(): string
    {
        return '';
    }
}
