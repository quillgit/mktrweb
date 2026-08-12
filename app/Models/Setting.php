<?php

namespace Mktr\Models;

use Mktr\Core\Model;

/**
 * Site-wide editable values: the home intro block, the office address, the
 * social links. Read on nearly every request, so the whole table is loaded
 * once per request and cached in the instance.
 */
class Setting extends Model
{
    /** @var string */
    protected $table = 'site_settings';

    /** @var array<string,array<string,mixed>>|null keyed by setting key */
    private static $cache;

    /**
     * @return array<string,array<string,mixed>>
     */
    public function map(string $locale, string $fallback): array
    {
        $key = $locale . '|' . $fallback;

        if (isset(self::$cache[$key])) {
            return self::$cache[$key];
        }

        $rows = $this->db()->select(
            'SELECT s.id, s.`group`, s.`key`, s.value, s.sort,
                    COALESCE(t.value, f.value) AS text,
                    m.path  AS media_path,  m.alt AS media_alt,
                    m2.path AS media_2_path
               FROM site_settings s
          LEFT JOIN site_setting_translations t ON t.setting_id = s.id AND t.locale = ?
          LEFT JOIN site_setting_translations f ON f.setting_id = s.id AND f.locale = ?
          LEFT JOIN media m  ON m.id  = s.media_id
          LEFT JOIN media m2 ON m2.id = s.media_2_id
           ORDER BY s.`group`, s.sort, s.id',
            [$locale, $fallback]
        );

        $keyed = [];
        foreach ($rows as $row) {
            $keyed[(string) $row['key']] = $row;
        }

        self::$cache[$key] = $keyed;

        return $keyed;
    }

    /**
     * Translated text if there is one, otherwise the locale-independent value,
     * otherwise the caller's default — so a page never renders an empty block
     * because nobody has filled the setting in yet.
     */
    public function text(string $key, string $locale, string $fallback, string $default = ''): string
    {
        $all = $this->map($locale, $fallback);

        if (!isset($all[$key])) {
            return $default;
        }

        $text = (string) (isset($all[$key]['text']) ? $all[$key]['text'] : '');

        if (trim($text) !== '') {
            return $text;
        }

        $value = (string) (isset($all[$key]['value']) ? $all[$key]['value'] : '');

        return trim($value) !== '' ? $value : $default;
    }

    public function media(string $key, string $locale, string $fallback, int $slot = 1): string
    {
        $all    = $this->map($locale, $fallback);
        $column = $slot === 2 ? 'media_2_path' : 'media_path';

        return isset($all[$key][$column]) && $all[$key][$column] !== null
            ? (string) $all[$key][$column]
            : '';
    }

    /* ---- admin ----------------------------------------------------------- */

    /**
     * @return array<int,array<string,mixed>>
     */
    public function adminRows(): array
    {
        return $this->db()->select('SELECT * FROM site_settings ORDER BY `group`, sort, id');
    }

    /**
     * @return array<int,array<string,string>> setting id => locale => value
     */
    public function allTranslations(): array
    {
        $rows   = $this->db()->select('SELECT setting_id, locale, value FROM site_setting_translations');
        $keyed  = [];

        foreach ($rows as $row) {
            $keyed[(int) $row['setting_id']][(string) $row['locale']] = (string) $row['value'];
        }

        return $keyed;
    }

    public function save(int $id, ?string $value, ?int $mediaId, ?int $media2Id, array $translations): void
    {
        $this->db()->transaction(function () use ($id, $value, $mediaId, $media2Id, $translations) {
            $this->db()->affected(
                'UPDATE site_settings SET value = ?, media_id = ?, media_2_id = ?, updated_at = ? WHERE id = ?',
                [$value, $mediaId, $media2Id, date('Y-m-d H:i:s'), $id]
            );

            foreach ($translations as $locale => $text) {
                $this->db()->run(
                    'INSERT INTO site_setting_translations (setting_id, locale, value)
                     VALUES (?, ?, ?)
                     ON DUPLICATE KEY UPDATE value = VALUES(value)',
                    [$id, $locale, $text]
                );
            }
        });

        self::$cache = null;
    }

    /**
     * @return array<string,mixed>|null
     */
    public function findByKey(string $key): ?array
    {
        return $this->db()->selectOne('SELECT * FROM site_settings WHERE `key` = ? LIMIT 1', [$key]);
    }
}
