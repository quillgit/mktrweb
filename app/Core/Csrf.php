<?php
/**
 * CSRF tokens. The legacy admin had none — any authenticated editor could be
 * made to delete content by visiting a third-party page.
 */

namespace Mktr\Core;

class Csrf
{
    const KEY = '_csrf_token';

    public static function token(): string
    {
        $token = Session::get(self::KEY);

        if (!is_string($token) || $token === '') {
            $token = bin2hex(random_bytes(32));
            Session::put(self::KEY, $token);
        }

        return $token;
    }

    public static function check(?string $candidate): bool
    {
        $token = Session::get(self::KEY);

        if (!is_string($token) || $token === '' || !is_string($candidate)) {
            return false;
        }

        return hash_equals($token, $candidate);
    }

    public static function field(): string
    {
        return '<input type="hidden" name="_token" value="' . htmlspecialchars(self::token(), ENT_QUOTES, 'UTF-8') . '">';
    }
}
