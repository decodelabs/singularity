<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity;

interface Uri
{
    public const DELIMITERS = '!\$&\'\(\)\*\+,;=';
    public const VALID_CHARACTERS = 'a-zA-Z0-9_\-\.~\pL';

    public static function fromString(string $uri): static;

    public function getScheme(): string;

    public function withPath(string $path): static;
    public function getPath(): string;
    public function hasPath(): bool;
    public static function normalizePath(?string $path): ?string;
}
