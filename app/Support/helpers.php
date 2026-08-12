<?php
/**
 * Global helpers available to controllers and templates.
 */

use Mktr\Core\Auth;
use Mktr\Core\Config;
use Mktr\Core\Csrf;
use Mktr\Core\Lang;
use Mktr\Core\Session;
use Mktr\Core\View;

if (!function_exists('e')) {
    /**
     * Escape for HTML output. Every template uses this by default.
     *
     * @param mixed $value
     */
    function e($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('__')) {
    function __(string $key, array $replace = []): string
    {
        return Lang::get($key, $replace);
    }
}

if (!function_exists('config')) {
    /**
     * @param  mixed $default
     * @return mixed
     */
    function config(string $key, $default = null)
    {
        return Config::get($key, $default);
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string
    {
        $base = rtrim((string) Config::get('app.base_path', ''), '/');

        return $base . '/' . ltrim($path, '/');
    }
}

if (!function_exists('locale')) {
    function locale(): string
    {
        return Lang::locale();
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        return Csrf::field();
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string
    {
        return Csrf::token();
    }
}

if (!function_exists('old')) {
    /**
     * @param  mixed $default
     * @return mixed
     */
    function old(string $key, $default = '')
    {
        $input = Session::oldInput();

        return array_key_exists($key, $input) ? $input[$key] : $default;
    }
}

if (!function_exists('errors')) {
    function errors(): array
    {
        $errors = Session::get('_flash.errors', []);

        return is_array($errors) ? $errors : [];
    }
}

if (!function_exists('error_for')) {
    function error_for(string $field): string
    {
        $errors = errors();

        return isset($errors[$field]) ? (string) $errors[$field] : '';
    }
}

if (!function_exists('partial')) {
    function partial(string $template, array $data = []): string
    {
        return View::partial($template, $data);
    }
}

if (!function_exists('auth_user')) {
    function auth_user(): ?array
    {
        return Auth::user();
    }
}

if (!function_exists('can')) {
    function can(string $ability): bool
    {
        return Auth::can($ability);
    }
}

if (!function_exists('str_slug')) {
    function str_slug(string $value): string
    {
        $value = trim(mb_strtolower($value, 'UTF-8'));
        $value = preg_replace('/[^\p{L}\p{Nd}]+/u', '-', $value);
        $value = preg_replace('/-+/', '-', (string) $value);

        return trim((string) $value, '-');
    }
}

if (!function_exists('format_date_id')) {
    /**
     * "12 Agustus 2026" — replaces the legacy TanggalIndo().
     */
    function format_date_id(?string $date, ?string $localeCode = null): string
    {
        if ($date === null || $date === '' || strtotime($date) === false) {
            return '';
        }

        $localeCode = $localeCode !== null ? $localeCode : Lang::locale();
        $timestamp  = strtotime($date);

        if ($localeCode === 'en') {
            return date('j F Y', $timestamp);
        }

        $months = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
        ];

        return (int) date('j', $timestamp) . ' ' . $months[(int) date('n', $timestamp)] . ' ' . date('Y', $timestamp);
    }
}

if (!function_exists('format_date_badge')) {
    /**
     * "12<br>Agu" — replaces the legacy TanggalBulan().
     */
    function format_date_badge(?string $date, ?string $localeCode = null): string
    {
        if ($date === null || $date === '' || strtotime($date) === false) {
            return '';
        }

        $localeCode = $localeCode !== null ? $localeCode : Lang::locale();
        $timestamp  = strtotime($date);

        if ($localeCode === 'en') {
            return date('j', $timestamp) . '<br>' . date('M', $timestamp);
        }

        $short = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        return (int) date('j', $timestamp) . '<br>' . $short[(int) date('n', $timestamp)];
    }
}

if (!function_exists('format_bytes')) {
    function format_bytes(int $bytes): string
    {
        if ($bytes < 1024) {
            return $bytes . ' B';
        }

        $units = ['KB', 'MB', 'GB'];
        $value = $bytes / 1024;
        $index = 0;

        while ($value >= 1024 && $index < count($units) - 1) {
            $value /= 1024;
            $index++;
        }

        return number_format($value, $value >= 10 ? 0 : 1) . ' ' . $units[$index];
    }
}
