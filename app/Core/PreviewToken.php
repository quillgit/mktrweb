<?php
/**
 * Signed, expiring preview links.
 *
 * Lets an editor (or someone they send the link to) view unpublished content
 * on the real front-end template without exposing drafts publicly. The payload
 * is HMAC-signed with the app key, so a token cannot be forged or edited.
 */

namespace Mktr\Core;

class PreviewToken
{
    const TTL = 3600;

    public static function create(string $type, int $id, string $locale, int $ttl = self::TTL): string
    {
        $payload = [
            't' => $type,
            'i' => $id,
            'l' => $locale,
            'e' => time() + $ttl,
        ];

        $encoded   = self::base64UrlEncode((string) json_encode($payload));
        $signature = self::sign($encoded);

        return $encoded . '.' . $signature;
    }

    /**
     * @return array{type:string,id:int,locale:string}|null
     */
    public static function verify(string $token): ?array
    {
        if (strpos($token, '.') === false) {
            return null;
        }

        list($encoded, $signature) = explode('.', $token, 2);

        if (!hash_equals(self::sign($encoded), $signature)) {
            return null;
        }

        $decoded = json_decode((string) self::base64UrlDecode($encoded), true);

        if (!is_array($decoded) || !isset($decoded['t'], $decoded['i'], $decoded['l'], $decoded['e'])) {
            return null;
        }

        if ((int) $decoded['e'] < time()) {
            return null;
        }

        return [
            'type'   => (string) $decoded['t'],
            'id'     => (int) $decoded['i'],
            'locale' => (string) $decoded['l'],
        ];
    }

    private static function sign(string $value): string
    {
        return self::base64UrlEncode(
            hash_hmac('sha256', $value, (string) Config::get('app.key', ''), true)
        );
    }

    private static function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }

    private static function base64UrlDecode(string $value): string
    {
        $padded = str_pad(strtr($value, '-_', '+/'), (int) (ceil(strlen($value) / 4) * 4), '=', STR_PAD_RIGHT);

        return (string) base64_decode($padded, true);
    }
}
