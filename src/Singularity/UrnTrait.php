<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity;

use Closure;

/**
 * @phpstan-require-implements Urn
 */
trait UrnTrait
{
    public function getScheme(): string
    {
        return 'urn';
    }


    public static function normalizeNamespace(
        string $namespace
    ): string {
        $namespace = strtolower($namespace);
        $namespace = (string)preg_replace('/[^a-z0-9]/', '-', $namespace);
        $namespace = (string)preg_replace('/-+/', '-', $namespace);
        $namespace = trim($namespace, '-');

        return $namespace;
    }

    public function withIdentifier(
        string|Closure $nss
    ): static {
        $output = clone $this;

        if ($nss instanceof Closure) {
            $nss = $nss($output->getIdentifier(), $this);
        }

        $output->identifier = static::normalizeIdentifier($nss);

        return $output;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public static function normalizeIdentifier(
        string $nss
    ): string {
        $nss = strtolower($nss);
        $nss = (string)preg_replace('/-+/', '-', $nss);
        $nss = trim($nss, '-');

        return $nss;
    }
}
