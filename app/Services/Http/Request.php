<?php

declare(strict_types=1);

namespace App\Services\Http;

class Request
{
    public static function uri(): string
    {
        return trim(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
            '/'
        );
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Returns a parameter from GET or POST payload.
     * The optional default is returned, if the parameter is not found.
     *
     * @param string|null $key
     * @param mixed|null $default
     * @return string|array|null|int
     */
    public static function input(?string $key = null, mixed $default = null): string|array|null|int
    {
        if (null === $key) {
            $values = array_merge(
                $_GET,
                $_POST
            );

            foreach ($values as $key => $value) {
                $values[$key] = self::formatInputValue($value);
            }

            return $values;
        }

        if (true === array_key_exists($key, $_GET)) {
            return self::formatInputValue($_GET[$key]);
        }

        if (true === array_key_exists($key, $_POST)) {
            return self::formatInputValue($_POST[$key]);
        }

        return $default;
    }

    /**
     * Returns a correct type for floats, integers, etc. coming as GET or POST parameters.
     *
     * @param mixed $value
     * @return float|int|string|null
     */
    private static function formatInputValue(mixed $value): float|int|string|null
    {
        $value = trim($value);

        if ($value === '') {
            $value = null;
        }

        return $value;
    }
}