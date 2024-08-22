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
    protected const Schemes = [
        'http' => 80,
        'https' => 443,
        null => 443
    ];

    public static function normalizeScheme(
        ?string $scheme
    ): ?string {
        $scheme = parent::normalizeScheme($scheme);

        if (!isset(self::Schemes[$scheme])) {
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
        if ($this->port === self::Schemes[$this->scheme]) {
            return null;
        }

        return parent::getPort();
    }

    public function hasPort(): bool
    {
        if ($this->port === self::Schemes[$this->scheme]) {
            return false;
        }

        return parent::hasPort();
    }
}
