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
    public const DELIMITERS = '!\$&\'\(\)\*\+,;=';
    public const VALID_CHARACTERS = 'a-zA-Z0-9_\-\.~\pL';

    public static function fromString(
        string $uri
    ): static;

    public function getScheme(): string;
}
