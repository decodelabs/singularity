<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use DecodeLabs\Exceptional;

class Http extends Generic
{
    public const SCHEMES = [
        'http' => 80,
        'https' => 443
    ];

    public static function normalizeScheme(string $scheme): string
    {
        $scheme = parent::normalizeScheme($scheme);

        if (!isset(self::SCHEMES[$scheme])) {
            throw Exceptional::InvalidArgument(
                'Scheme ' . $scheme . ' is not supported'
            );
        }

        return $scheme;
    }

    public function isSecure(): bool
    {
        return $this->scheme === 'https';
    }

    public function getPort(): ?int
    {
        if ($this->port === self::SCHEMES[$this->scheme]) {
            return null;
        }

        return parent::getPort();
    }

    public function hasPort(): bool
    {
        if ($this->port === self::SCHEMES[$this->scheme]) {
            return false;
        }

        return parent::hasPort();
    }
}
