<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity;

use DecodeLabs\Exceptional;

trait UrnTrait
{
    public function getScheme(): string
    {
        return 'urn';
    }


    public function withPath(?string $path): static
    {
        throw Exceptional::BadMethodCall(
            'Typed URNs cannot change namespace'
        );
    }

    public function getPath(): string
    {
        return $this->getNamespace() . ':' . $this->getIdentifier();
    }

    public function hasPath(): bool
    {
        return true;
    }

    public static function normalizePath(?string $path): ?string
    {
        if ($path === null) {
            return null;
        }

        if (!preg_match('/^([a-z0-9][a-z0-9-]{1,31}):(.+)$/i', $path)) {
            throw Exceptional::InvalidArgument(
                'Invalid URN path: ' . $path
            );
        }

        $parts = explode(':', $path, 2);
        return static::normalizeNamespace($parts[0]) . ':' . static::normalizeIdentifier($parts[1]);
    }


    public static function normalizeNamespace(string $namespace): string
    {
        $namespace = strtolower($namespace);
        $namespace = (string)preg_replace('/[^a-z0-9]/', '-', $namespace);
        $namespace = (string)preg_replace('/-+/', '-', $namespace);
        $namespace = trim($namespace, '-');

        return $namespace;
    }

    public function withIdentifier(string $nss): static
    {
        $output = clone $this;
        $output->identifier = static::normalizeIdentifier($nss);

        return $output;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public static function normalizeIdentifier(string $nss): string
    {
        $nss = strtolower($nss);
        $nss = (string)preg_replace('/-+/', '-', $nss);
        $nss = trim($nss, '-');

        return $nss;
    }
}
