<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs;

use DecodeLabs\Singularity\Path;
use DecodeLabs\Singularity\Uri;
use DecodeLabs\Singularity\Url;
use DecodeLabs\Singularity\Url\Generic as GenericUrl;
use DecodeLabs\Singularity\Urn;
use DecodeLabs\Singularity\Urn\Generic as GenericUrn;

class Singularity
{
    /**
     * @phpstan-return ($uri is null ? null : Uri)
     */
    public static function uri(
        string|Uri|null $uri
    ): ?Uri {
        if ($uri === null) {
            return null;
        }

        if ($uri instanceof Uri) {
            return $uri;
        }

        if (!preg_match('/^([a-z][a-z0-9+.-]*):/i', $uri, $matches)) {
            $scheme = 'Http';

            if (substr($uri, 0, 2) !== '//') {
                $uri = 'https://' . $uri;
            }
        } else {
            $scheme = ucfirst(strtolower($matches[1]));
        }

        if ($scheme === 'Urn') {
            if (!preg_match('/^urn:([a-z0-9][a-z0-9-]{1,31}):/i', $uri, $matches)) {
                throw Exceptional::InvalidArgument(
                    'Invalid URN: ' . $uri
                );
            }

            if (!$class = Archetype::tryResolve(Urn::class, $matches[1])) {
                $class = GenericUrn::class;
            }
        } else {
            if ($scheme === 'Https') {
                $scheme = 'Http';
            }

            if (!$class = Archetype::tryResolve(Url::class, $scheme)) {
                $class = GenericUrl::class;
            }
        }

        return $class::fromString($uri);
    }

    /**
     * @phpstan-return ($uri is null ? null : Url)
     */
    public static function url(
        string|Uri|null $uri
    ): ?Url {
        $output = self::uri($uri);

        if (
            $output !== null &&
            !$output instanceof Url
        ) {
            throw Exceptional::InvalidArgument(
                'URI is not a URL'
            );
        }

        return $output;
    }

    /**
     * @phpstan-return ($uri is null ? null : Urn)
     */
    public static function urn(
        string|Uri|null $uri
    ): ?Urn {
        $output = self::uri($uri);

        if (
            $output !== null &&
            !$output instanceof Urn
        ) {
            throw Exceptional::InvalidArgument(
                'URI is not a URN'
            );
        }

        return $output;
    }

    public static function path(
        string|Path|Url|null $path,
        ?string $separator = null
    ): ?Path {
        if ($path instanceof Url) {
            $path = $path->getPath();
        }

        if ($path === null) {
            return null;
        }

        if ($path instanceof Path) {
            return $path;
        }

        return Path::fromString($path, $separator);
    }

    public static function canonicalPath(
        string|Path|Url|null $path,
        ?string $separator = null
    ): ?Path {
        return self::path($path, $separator)?->canonicalize();
    }
}
