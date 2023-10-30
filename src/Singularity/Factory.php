<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity;

use DecodeLabs\Singularity;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

class Factory implements UriFactoryInterface
{
    public function createUri(
        string $uri = ''
    ): UriInterface {
        return Singularity::url($uri);
    }
}
