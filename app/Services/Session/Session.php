<?php

declare(strict_types=1);

namespace App\Services\Session;

use App\Models\User;

class Session
{
    private ?User $user = null;

    public function __construct()
    {
        if (false === session_id()) {
            $this->start();
        }

        if (null !== $this->get('user_id')) {
            $userId = (int)$this->get('user_id');
            $this->user = User::find($userId);
        }
    }

    /** Starts a session */
    public function start(): void
    {
        session_start();
    }

    /** Destroys current session */
    public function destroy(): void
    {
        session_destroy();
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }
}
