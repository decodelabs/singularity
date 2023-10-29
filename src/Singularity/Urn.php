<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity;

interface Urn extends Uri
{
    public function getNamespace(): string;

    public function withIdentifier(string $nss): static;
    public function getIdentifier(): string;
    public static function normalizeIdentifier(string $nss): string;
}
