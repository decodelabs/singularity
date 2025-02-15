<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity;

use Stringable;

interface Uri extends Stringable
{
    public const string Delimiters = '!\$&\'\(\)\*\+,;=';
    public const string ValidCharacters = 'a-zA-Z0-9_\-\.~\pL';

    public ?string $scheme { get; }

    public static function fromString(
        string $uri
    ): static;

    public function getScheme(): string;
}
