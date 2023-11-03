<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use DecodeLabs\Exceptional;
use DecodeLabs\Glitch\Dumpable;
use DecodeLabs\Singularity\Url;

class Mailto implements
    Url,
    Dumpable
{
    use NoSchemeTrait;
    use UsernameTrait;
    use HostTrait;
    use PortTrait;
    use AuthorityTrait;
    use NoPathTrait;
    use QueryTrait;
    use NoFragmentTrait;

    public static function fromString(
        string $uri
    ): static {
        $parts = parse_url('http://' . parse_url($uri, PHP_URL_PATH) . '?' . parse_url($uri, PHP_URL_QUERY));

        if ($parts === false) {
            throw Exceptional::InvalidArgument(
                'Unable to parse uri',
                null,
                $uri
            );
        }

        return new static(
            username: $parts['user'] ?? null,
            host: $parts['host'] ?? null,
            port: $parts['port'] ?? null,
            query: $parts['query'] ?? null,
        );
    }

    final public function __construct(
        ?string $username = null,
        ?string $host = null,
        ?int $port = null,
        ?string $query = null,
    ) {
        $this->username = static::normalizeUserInfo($username);
        $this->host = static::normalizeHost($host);
        $this->port = static::normalizePort($port);
        $this->query = static::normalizeQuery($query);
    }

    public function getScheme(): string
    {
        return 'mailto';
    }

    public function getEmailAddress(): string
    {
        $output = $this->username;
        $output .= '@';
        $output .= $this->host;

        if ($this->port !== null) {
            $output .= ':' . $this->port;
        }

        return $output;
    }

    public function __toString(): string
    {
        $output = 'mailto:';
        $output .= $this->getEmailAddress();

        if ($this->query !== null) {
            $output .= '?' . $this->query;
        }

        return $output;
    }

    public function glitchDump(): iterable
    {
        $properties = [
            'email' => $this->getEmailAddress()
        ];

        if ($this->query !== null) {
            $properties['query'] = $this->query;
        }

        yield 'properties' => $properties;
    }
}
