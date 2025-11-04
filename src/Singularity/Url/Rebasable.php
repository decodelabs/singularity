<?php

/**
 * Singularity
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use DecodeLabs\Singularity\Url;

interface Rebasable extends Url
{
    public function rebase(
        Url $base
    ): static;
}
