<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity;

use Closure;
use DecodeLabs\Collections\Tree;
use DecodeLabs\Compass\Ip;
use Psr\Http\Message\UriInterface;

interface Url extends Uri, UriInterface
{
    /**
     * @param string|Closure(string, static):string $scheme
     */
    public function withScheme(
        string|Closure $scheme
    ): static;

    /**
     * @param string|Closure(?string, static):?string|null $username
     */
    public function withUsername(
        string|Closure|null $username
    ): static;
    public function getUsername(): string;
    public function hasUsername(): bool;

    /**
     * @param string|Closure(?string, static):?string|null $password
     */
    public function withPassword(
        string|Closure|null $password
    ): static;
    public function getPassword(): string;
    public function hasPassword(): bool;

    /**
     * @param string|Closure(?string, ?string, static):?string|null $username
     */
    public function withUserInfo(
        string|Closure|null $username,
        string|null $password = null
    ): static;
    public static function normalizeUserInfo(?string $credential): ?string;

    /**
     * @param string|Ip|Closure(string|Ip|null, static):(string|Ip|null)|null $host
     */
    public function withHost(
        string|Ip|Closure|null $host
    ): static;
    public function hasHost(): bool;
    public static function normalizeHost(?string $host): ?string;

    /**
     * @param int|string|Closure(?int, static):?int|null $port
     */
    public function withPort(
        int|string|Closure|null $port
    ): static;
    public function hasPort(): bool;
    public static function normalizePort(
        int|string|null $port
    ): ?int;

    /**
     * @param string|Path|Closure(?Path, static): (string|Path|null)|null $path
     */
    public function withPath(
        string|Path|Closure|null $path
    ): static;
    public function parsePath(): ?Path;
    public function hasPath(): bool;
    public static function normalizePath(
        string|Path|null $path
    ): ?string;




    /**
     * @param string|array<int|float|string|null>|Tree<int|float|string|null>|Closure(Tree<int|float|string|null>, static): (string|array<int|float|string|null>|Tree<int|float|string|null>|null)|null $query
     */
    public function withQuery(
        string|array|Tree|Closure|null $query
    ): static;

    /**
     * @return Tree<int|float|string|null>
     */
    public function parseQuery(): Tree;

    public function hasQuery(): bool;

    /**
     * @param string|array<int|float|string|null>|Tree<int|float|string|null>|null $query
     */
    public static function normalizeQuery(
        string|array|Tree|null $query
    ): ?string;


    /**
     * @param string|Closure(?string, static):?string|null $fragment
     */
    public function withFragment(
        string|Closure|null $fragment
    ): static;
    public function hasFragment(): bool;
    public static function normalizeFragment(?string $fragment): ?string;
}
