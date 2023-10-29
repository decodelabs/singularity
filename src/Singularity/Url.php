<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity;

use DecodeLabs\Collections\Tree;
use Psr\Http\Message\UriInterface;

interface Url extends Uri, UriInterface
{
    public function withUsername(?string $username): static;
    public function getUsername(): string;
    public function hasUsername(): bool;

    public function withPassword(?string $password): static;
    public function getPassword(): string;
    public function hasPassword(): bool;

    public static function normalizeUserInfo(?string $credential): ?string;

    public function hasHost(): bool;
    public static function normalizeHost(?string $host): ?string;

    public function hasPort(): bool;
    public static function normalizePort(
        int|string|null $port
    ): ?int;

    public function withPath(string $path): static;

    public function hasQuery(): bool;
    public static function normalizeQuery(?string $query): ?string;

    /**
     * @param Tree<int|float|string|null>|null $tree
     */
    public function withQueryTree(?Tree $tree): static;

    /**
     * @return Tree<int|float|string|null>
     */
    public function getQueryTree(): Tree;

    public function hasFragment(): bool;
    public static function normalizeFragment(?string $fragment): ?string;
}
