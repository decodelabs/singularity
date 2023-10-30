<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity;

use Closure;

interface Urn extends Uri
{
    public function getNamespace(): string;

    /**
     * @param string|Closure(string, static):string $nss
     */
    public function withIdentifier(
        string|Closure $nss
    ): static;
    public function getIdentifier(): string;
    public static function normalizeIdentifier(string $nss): string;
}
