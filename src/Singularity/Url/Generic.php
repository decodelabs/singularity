<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use DecodeLabs\Exceptional;
use DecodeLabs\Nuance\Dumpable;
use DecodeLabs\Nuance\Entity\NativeObject as NuanceEntity;
use DecodeLabs\Singularity\Url;

class Generic implements
    Url,
    Rebasable,
    Dumpable
{
    use SchemeTrait;
    use UserInfoTrait;
    use HostTrait;
    use PortTrait;
    use AuthorityTrait;
    use PathTrait;
    use QueryTrait;
    use FragmentTrait;
    use RebaseTrait;

    public static function fromString(
        string $uri
    ): static {
        $parts = parse_url($uri);

        if ($parts === false) {
            throw Exceptional::InvalidArgument(
                message: 'Unable to parse uri: ' . $uri,
                data: $uri
            );
        }

        return new static(
            scheme: $parts['scheme'] ?? null,
            username: $parts['user'] ?? null,
            password: $parts['pass'] ?? null,
            host: $parts['host'] ?? null,
            port: $parts['port'] ?? null,
            path: $parts['path'] ?? null,
            query: $parts['query'] ?? null,
            fragment: $parts['fragment'] ?? null
        );
    }

    final public function __construct(
        ?string $scheme,
        ?string $username = null,
        ?string $password = null,
        ?string $host = null,
        ?int $port = null,
        ?string $path = null,
        ?string $query = null,
        ?string $fragment = null
    ) {
        $this->scheme = static::normalizeScheme($scheme);
        $this->username = static::normalizeUserInfo($username);
        $this->password = static::normalizeUserInfo($password);
        $this->host = static::normalizeHost($host);
        $this->port = static::normalizePort($port);
        $this->path = static::normalizePath($path);
        $this->query = static::normalizeQuery($query);
        $this->fragment = static::normalizeFragment($fragment);
    }


    /**
     * Convert to string
     */
    public function __toString(): string
    {
        $output = '';

        if ($this->scheme !== null) {
            $output .= $this->scheme . ':';
        }

        if (!empty($authority = $this->getAuthority())) {
            $output .= '//' . $authority;
        }

        if ($this->path !== null) {
            $output .= $this->path;
        }

        if ($this->query !== null) {
            $output .= '?' . $this->query;
        }

        if ($this->fragment !== null) {
            $output .= '#' . $this->fragment;
        }

        return $output;
    }

    public function toNuanceEntity(): NuanceEntity
    {
        $entity = new NuanceEntity($this);
        $entity->definition = $this->__toString();

        $entity->meta = [
            'scheme' => $this->scheme,
            'username' => $this->username,
            'password' => $this->password,
            'host' => $this->host,
            'port' => $this->port,
            'path' => $this->path,
            'query' => $this->query,
            'fragment' => $this->fragment
        ];

        return $entity;
    }
}
