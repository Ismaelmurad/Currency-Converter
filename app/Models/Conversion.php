<?php

declare(strict_types=1);

namespace App\Models;

use DateTime;

class Conversion extends Model
{
    protected string $table = 'conversions';

    public ?int $user_id = null;
    public int $base_currency_id;
    public int $target_currency_id;
    public float $exchange_rate;
    public float $value;
    public float $result;
    public ?string $user_agent = null;
    public ?string $ip_address = null;
    public ?string $created_at = null;

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): Conversion
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getBaseCurrencyId(): int
    {
        return $this->base_currency_id;
    }

    public function setBaseCurrencyId(int $base_currency_id): Conversion
    {
        $this->base_currency_id = $base_currency_id;
        return $this;
    }

    public function getTargetCurrencyId(): int
    {
        return $this->target_currency_id;
    }

    public function setTargetCurrencyId(int $target_currency_id): Conversion
    {
        $this->target_currency_id = $target_currency_id;
        return $this;
    }

    public function getExchangeRate(): float
    {
        return $this->exchange_rate;
    }

    public function setExchangeRate(float $exchange_rate): Conversion
    {
        $this->exchange_rate = $exchange_rate;
        return $this;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): Conversion
    {
        $this->value = $value;
        return $this;
    }

    public function getResult(): float
    {
        return $this->result;
    }

    public function setResult(float $result): Conversion
    {
        $this->result = $result;
        return $this;
    }

    public function getUserAgent(): string
    {
        return $this->user_agent;
    }

    public function setUserAgent(?string $user_agent): Conversion
    {
        $this->user_agent = $user_agent;
        return $this;
    }

    public function getIpAddress(): string
    {
        return $this->ip_address;
    }

    public function setIpAddress(string $ip_address): Conversion
    {
        $this->ip_address = $ip_address;
        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        if (null === $this->created_at) {
            return null;
        }

        return DateTime::createFromFormat('Y-m-d H:i:s', $this->created_at);
    }

    public function setCreatedAt(?string $created_at): Conversion
    {
        $this->created_at = $created_at;
        return $this;
    }

}