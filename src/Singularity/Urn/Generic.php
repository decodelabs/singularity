<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Urn;

use Closure;
use DecodeLabs\Exceptional;
use DecodeLabs\Singularity\Urn;
use DecodeLabs\Singularity\UrnTrait;

class Generic implements Urn
{
    use UrnTrait;

    protected string $namespace;
    protected string $identifier;

    /**
     * Create Generic URN from string
     */
    public static function fromString(string $urn): static
    {
        if (!preg_match('/^urn:([a-z0-9][a-z0-9-]{1,31}):(.+)$/i', $urn, $matches)) {
            throw Exceptional::InvalidArgument(
                'Invalid URN: ' . $urn
            );
        }

        return new static($matches[1], $matches[2]);
    }

    final public function __construct(
        string $namespace,
        string $identifier
    ) {
        $this->namespace = static::normalizeNamespace($namespace);
        $this->identifier = static::normalizeIdentifier($identifier);
    }

    public function withNamespace(
        string|Closure $namespace
    ): static {
        $output = clone $this;

        if ($namespace instanceof Closure) {
            $namespace = $namespace($this->namespace, $this);
        }

        $output->namespace = static::normalizeNamespace($namespace);

        return $output;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }
}
