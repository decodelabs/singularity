<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use Closure;

trait UserInfoTrait
{
    use UsernameTrait;

    protected ?string $password = null;

    public function withPassword(
        string|Closure|null $password
    ): static {
        if ($password === $this->password) {
            return $this;
        }

        $output = clone $this;

        if ($password instanceof Closure) {
            $password = $password($this->password, $this);
        }

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
        string|Closure|null $username,
        string|null $password = null
    ): static {
        $output = clone $this;

        if ($username instanceof Closure) {
            $result = $username($this->username, $this->password, $this);

            if ($result === null) {
                $username = $password = null;
            } else {
                [$username, $password] = explode(':', $result);
            }
        }

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
