<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Role;

class User extends Model
{
    protected string $table = 'users';
    public string $first_name;
    public string $last_name;
    public string $email;
    public string $password;
    public bool $is_active;
    public ?string $first_visited_at = null;
    public ?string $created_at = null;
    public ?string $updated_at = null;
    public string $role;

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     * @return User
     */
    public function setFirstName(string $first_name): User
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     * @return User
     */
    public function setLastName(string $last_name): User
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $this->password = $password;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * @param bool $is_active
     * @return User
     */
    public function setIsActive(bool $is_active): User
    {
        $this->is_active = $is_active;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstVisitedAt(): ?string
    {
        return $this->first_visited_at;
    }

    /**
     * @param string|null $first_visited_at
     * @return User
     */
    public function setFirstVisitedAt(?string $first_visited_at): User
    {
        $this->first_visited_at = $first_visited_at;
        return $this;
    }


    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    /**
     * @param string|null $created_at
     * @return User
     */
    public function setCreatedAt(?string $created_at): User
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }

    /**
     * @param string|null $updated_at
     * @return User
     */
    public function setUpdatedAt(?string $updated_at): User
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return Role::from($this->role);
    }

    /**
     * @param Role $role
     * @return User
     */
    public function setRole(Role $role): User
    {
        $this->role = $role->value;
        return $this;
    }

}

