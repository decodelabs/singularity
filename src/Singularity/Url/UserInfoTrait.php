<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

trait UserInfoTrait
{
    use UsernameTrait;

    protected ?string $password = null;

    public function withPassword(?string $password): static
    {
        if ($password === $this->password) {
            return $this;
        }

        $output = clone $this;
        $output->password = static::normalizeUserInfo($password);

        return $output;
    }

    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function hasPassword(): bool
    {
        return $this->password !== null;
    }

    public function withUserInfo(
        ?string $username,
        ?string $password = null
    ): static {
        $output = clone $this;
        $output->username = static::normalizeUserInfo($username);
        $output->password = static::normalizeUserInfo($password);

        return $output;
    }

    public function getUserInfo(): string
    {
        $output = $this->getUsername();

        if ($this->hasPassword()) {
            $output .= ':' . $this->getPassword();
        }

        return $output;
    }
}
