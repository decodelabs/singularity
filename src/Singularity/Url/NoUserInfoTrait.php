<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use Closure;
use DecodeLabs\Singularity\Url;

/**
 * @phpstan-require-implements Url
 */
trait NoUserInfoTrait
{
    public function withUsername(
        string|Closure|null $username
    ): static {
        throw Exceptional::Logic(
            'This URL does not support a username'
        );
    }

    public function getUsername(): string
    {
        return '';
    }

    public function hasUsername(): bool
    {
        return false;
    }

    public function withPassword(
        string|Closure|null $password
    ): static {
        throw Exceptional::Logic(
            'This URL does not support a password'
        );
    }

    public function getPassword(): string
    {
        return '';
    }

    public function hasPassword(): bool
    {
        return false;
    }

    public function withUserInfo(
        string|Closure|null $username,
        string|null $password = null
    ): static {
        throw Exceptional::Logic(
            'This URL does not support user info'
        );
    }

    public function getUserInfo(): string
    {
        return '';
    }

    public function hasUserInfo(): bool
    {
        return false;
    }

    public static function normalizeUserInfo(
        ?string $credential
    ): ?string {
        throw Exceptional::Logic(
            'This URL does not support user info'
        );
    }
}
