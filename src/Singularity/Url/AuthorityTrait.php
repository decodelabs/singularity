<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use DecodeLabs\Singularity\Url;

/**
 * @phpstan-require-implements Url
 */
trait AuthorityTrait
{
    public function getAuthority(): string
    {
        $output = '';

        if ($this->hasUsername()) {
            $output .= $this->getUsername();

            if ($this->hasPassword()) {
                $output .= ':' . $this->getPassword();
            }

            $output .= '@';
        }

        if ($this->hasHost()) {
            $output .= $this->getHost();
        }

        if ($this->hasPort()) {
            $output .= ':' . $this->getPort();
        }

        return $output;
    }
}
