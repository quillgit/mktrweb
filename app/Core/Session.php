<?php

namespace Mktr\Core;

class Session
{
    /** @var bool */
    private static $started = false;

    public static function start(): void
    {
        if (self::$started || session_status() === PHP_SESSION_ACTIVE) {
            self::$started = true;
            return;
        }

        if (!headers_sent()) {
            session_set_cookie_params([
                'lifetime' => 0,
                'path'     => '/',
                'httponly' => true,
                'samesite' => 'Lax',
                'secure'   => !empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off',
            ]);
            session_name((string) Config::get('app.session_name', 'mktr_session'));
            session_start();
        }

        self::$started = true;
    }

    /**
     * @param  mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        self::start();

        return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
    }

    /**
     * @param mixed $value
     */
    public static function put(string $key, $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function has(string $key): bool
    {
        self::start();

        return isset($_SESSION[$key]);
    }

    public static function forget(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }

    public static function regenerate(): void
    {
        self::start();

        if (!headers_sent()) {
            session_regenerate_id(true);
        }
    }

    public static function destroy(): void
    {
        self::start();
        $_SESSION = [];

        if (!headers_sent()) {
            session_destroy();
        }

        self::$started = false;
    }

    /* ---- flash ---------------------------------------------------------- */

    /**
     * @param mixed $value
     */
    public static function flash(string $key, $value): void
    {
        self::put('_flash.' . $key, $value);
    }

    /**
     * @param  mixed $default
     * @return mixed
     */
    public static function pull(string $key, $default = null)
    {
        $value = self::get('_flash.' . $key, $default);
        self::forget('_flash.' . $key);

        return $value;
    }

    /**
     * Keep submitted input across a validation redirect.
     */
    public static function flashInput(array $input): void
    {
        unset($input['_token'], $input['_method'], $input['password'], $input['password_confirmation']);
        self::flash('_old', $input);
    }

    public static function oldInput(): array
    {
        $old = self::get('_flash._old', []);

        return is_array($old) ? $old : [];
    }

    public static function clearOldInput(): void
    {
        self::forget('_flash._old');
    }
}
