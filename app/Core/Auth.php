<?php
/**
 * Authentication and role checks.
 *
 * The legacy admin stored the password hash in $_SESSION and re-validated by
 * interpolating it into a SQL string on every request. Here the session holds
 * only the user id plus a fingerprint of the client; the user row is re-read
 * through a prepared statement, and login is rate limited.
 */

namespace Mktr\Core;

use Mktr\Models\User;

class Auth
{
    const SESSION_USER = '_auth_user_id';
    const SESSION_PRINT = '_auth_fingerprint';
    const MAX_ATTEMPTS = 5;
    const LOCKOUT_SECONDS = 900;

    /** @var array<string,mixed>|null */
    private static $cached;

    private static function fingerprint(Request $request): string
    {
        return hash('sha256', $request->userAgent() . '|' . Config::get('app.key', ''));
    }

    public static function attempt(string $username, string $password, Request $request): bool
    {
        if (self::isLockedOut($username)) {
            return false;
        }

        $users = new User();
        $user  = $users->findByUsername($username);

        // Always run a hash comparison so a missing user and a wrong password
        // take a similar amount of time.
        $hash = $user !== null ? (string) $user['password'] : '$2y$10$invalidinvalidinvalidinvalidinvalidinvalidinvalidinvalidinv';

        if (!password_verify($password, $hash) || $user === null || (int) $user['status'] !== 1) {
            self::recordFailure($username);
            return false;
        }

        if (password_needs_rehash($hash, PASSWORD_DEFAULT)) {
            $users->update((int) $user['id'], ['password' => password_hash($password, PASSWORD_DEFAULT)]);
        }

        Session::regenerate();
        Session::put(self::SESSION_USER, (int) $user['id']);
        Session::put(self::SESSION_PRINT, self::fingerprint($request));
        Session::forget(self::attemptKey($username));

        $users->touchLogin((int) $user['id']);
        self::$cached = null;

        return true;
    }

    public static function logout(): void
    {
        self::$cached = null;
        Session::destroy();
    }

    /**
     * @return array<string,mixed>|null
     */
    public static function user(?Request $request = null): ?array
    {
        if (self::$cached !== null) {
            return self::$cached;
        }

        $id = Session::get(self::SESSION_USER);

        if (!is_int($id) && !ctype_digit((string) $id)) {
            return null;
        }

        if ($request !== null) {
            $expected = Session::get(self::SESSION_PRINT);
            if (!is_string($expected) || !hash_equals($expected, self::fingerprint($request))) {
                self::logout();
                return null;
            }
        }

        $user = (new User())->findActive((int) $id);

        if ($user === null) {
            self::logout();
            return null;
        }

        self::$cached = $user;

        return $user;
    }

    public static function check(?Request $request = null): bool
    {
        return self::user($request) !== null;
    }

    public static function id(): ?int
    {
        $user = self::user();

        return $user === null ? null : (int) $user['id'];
    }

    /**
     * Role hierarchy: admin can do everything an editor can, and so on.
     */
    public static function can(string $ability): bool
    {
        $user = self::user();

        if ($user === null) {
            return false;
        }

        $role = isset($user['role_slug']) ? (string) $user['role_slug'] : 'contributor';

        $matrix = [
            'admin'       => ['content.view', 'content.create', 'content.edit', 'content.delete', 'content.publish', 'media.upload', 'media.delete', 'users.manage', 'settings.manage'],
            'editor'      => ['content.view', 'content.create', 'content.edit', 'content.delete', 'content.publish', 'media.upload', 'media.delete'],
            'contributor' => ['content.view', 'content.create', 'content.edit', 'media.upload'],
        ];

        $allowed = isset($matrix[$role]) ? $matrix[$role] : [];

        return in_array($ability, $allowed, true);
    }

    /* ---- login throttling ------------------------------------------------ */

    private static function attemptKey(string $username): string
    {
        return '_login_attempts_' . md5(strtolower($username));
    }

    public static function isLockedOut(string $username): bool
    {
        $record = Session::get(self::attemptKey($username));

        if (!is_array($record) || !isset($record['count'], $record['at'])) {
            return false;
        }

        if ((int) $record['count'] < self::MAX_ATTEMPTS) {
            return false;
        }

        return (time() - (int) $record['at']) < self::LOCKOUT_SECONDS;
    }

    private static function recordFailure(string $username): void
    {
        $key    = self::attemptKey($username);
        $record = Session::get($key);
        $count  = is_array($record) && isset($record['count']) ? (int) $record['count'] : 0;

        Session::put($key, ['count' => $count + 1, 'at' => time()]);
    }
}
