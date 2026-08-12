<?php
/**
 * Configuration registry.
 *
 * Files in config/ return arrays; they are loaded on demand and addressed with
 * dot notation: config('database.mysql.host').
 */

namespace Mktr\Core;

class Config
{
    /** @var array<string,array> */
    private static $loaded = [];

    /** @var string */
    private static $path = '';

    public static function setPath(string $path): void
    {
        self::$path = rtrim($path, '/');
    }

    /**
     * @param  mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        $segments = explode('.', $key);
        $file     = array_shift($segments);

        if (!isset(self::$loaded[$file])) {
            $path = self::$path . '/' . $file . '.php';
            self::$loaded[$file] = is_file($path) ? require $path : [];
        }

        $value = self::$loaded[$file];

        foreach ($segments as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }

        return $value;
    }
}
