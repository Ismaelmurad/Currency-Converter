<?php

declare(strict_types=1);

namespace App\Models;

class Currency extends Model
{
    protected string $table = 'currencies';

    public string $name;
    public string $iso_4217;
    public bool $is_active = true;
    public ?string $symbol = null;
    public ?string $created_at = null;
    public ?string $updated_at = null;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Currency
     */
    public function setName(string $name): Currency
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getIso4217(): string
    {
        return $this->iso_4217;
    }

    /**
     * @param string $iso_4217
     * @return Currency
     */
    public function setIso4217(string $iso_4217): Currency
    {
        $this->iso_4217 = $iso_4217;
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
     * @return Currency
     */
    public function setIsActive(bool $is_active): Currency
    {
        $this->is_active = $is_active;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    /**
     * @param string|null $symbol
     * @return Currency
     */
    public function setSymbol(?string $symbol): Currency
    {
        $this->symbol = $symbol;
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
     * @return Currency
     */
    public function setCreatedAt(?string $created_at): Currency
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
     * @return Currency
     */
    public function setUpdatedAt(?string $updated_at): Currency
    {
        $this->updated_at = $updated_at;
        return $this;
    }
}