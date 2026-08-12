<?php
/**
 * UI string translation.
 *
 * Content translations live in *_translations tables; this covers interface
 * labels only. Files: resources/lang/{locale}.php returning a flat array.
 */

namespace Mktr\Core;

class Lang
{
    /** @var string */
    private static $locale = 'id';

    /** @var array<string,array<string,string>> */
    private static $lines = [];

    /** @var string */
    private static $path = '';

    public static function setPath(string $path): void
    {
        self::$path = rtrim($path, '/');
    }

    public static function setLocale(string $locale): void
    {
        self::$locale = $locale;
    }

    public static function locale(): string
    {
        return self::$locale;
    }

    public static function get(string $key, array $replace = []): string
    {
        if (!isset(self::$lines[self::$locale])) {
            $file = self::$path . '/' . self::$locale . '.php';
            self::$lines[self::$locale] = is_file($file) ? (array) require $file : [];
        }

        $line = isset(self::$lines[self::$locale][$key])
            ? (string) self::$lines[self::$locale][$key]
            : $key;

        foreach ($replace as $search => $value) {
            $line = str_replace(':' . $search, (string) $value, $line);
        }

        return $line;
    }

    /**
     * Pick the right column from a translations row, falling back to the
     * default locale when a translation is missing.
     *
     * @param  array<int,array<string,mixed>> $translations rows keyed by 'locale'
     * @return array<string,mixed>|null
     */
    public static function pick(array $translations, ?string $locale = null): ?array
    {
        $locale  = $locale !== null ? $locale : self::$locale;
        $default = (string) Config::get('app.default_locale', 'id');

        foreach ($translations as $row) {
            if (isset($row['locale']) && $row['locale'] === $locale) {
                return $row;
            }
        }

        foreach ($translations as $row) {
            if (isset($row['locale']) && $row['locale'] === $default) {
                return $row;
            }
        }

        return $translations === [] ? null : reset($translations);
    }
}
