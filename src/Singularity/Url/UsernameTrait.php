<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use Closure;
use DecodeLabs\Exceptional;

trait UsernameTrait
{
    protected ?string $username = null;

    public function withUsername(
        string|Closure|null $username
    ): static {
        if ($username === $this->username) {
            return $this;
        }

        $output = clone $this;

        if ($username instanceof Closure) {
            $username = $username($this->username, $this);
        }

        $output->username = static::normalizeUserInfo($username);

        return $output;
    }

    public function getUsername(): string
    {
        return (string)$this->username;
    }

    public function hasUsername(): bool
    {
        return $this->username !== null;
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
        $output = clone $this;

        if ($username instanceof Closure) {
            $username = $username($this->username, null, $this);
        }

        $output->username = static::normalizeUserInfo($username);
        return $output;
    }

    public function getUserInfo(): string
    {
        return $this->getUsername();
    }

    public static function normalizeUserInfo(?string $credential): ?string
    {
        if (
            $credential === null ||
            $credential === ''
        ) {
            return null;
        }

        return preg_replace_callback(
            '#(?:[^%' . self::VALID_CHARACTERS . self::DELIMITERS . ']+|%(?![A-Fa-f0-9]{2}))#u',
            function ($matches) {
                return rawurlencode($matches[0]);
            },
            $credential
        );
    }
}
