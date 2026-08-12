<?php
/**
 * tabel_home (one row) -> site_settings.
 *
 * The home page's opening block was a one-row table with a title, a body and
 * two photographs. There is nothing table-shaped about it, so it becomes
 * settings rather than a fifth content type.
 */

namespace Mktr\Import;


class SettingsImporter extends Importer
{
    public function name(): string
    {
        return 'settings';
    }

    public function run(): void
    {
        $table = 'tabel_home';

        if (!$this->tableExists($table)) {
            $this->note($table . ': table not present, skipped');
            return;
        }

        $rows = $this->fetchAll('SELECT * FROM ' . $table . ' ORDER BY id_home LIMIT 1');
        $this->count($table, 'source', count($rows));

        if ($rows === []) {
            $this->note($table . ': no rows');
            return;
        }

        $row = $rows[0];

        if ($this->dryRun) {
            $this->count($table, 'imported', 1);
            return;
        }

        /*
         * `tabel_home` has no title_english, so only the Indonesian heading is
         * imported. Writing "Tentang Kami" into the English row as a fallback
         * would look deliberate and stop the template's own translated default
         * ("About Us") from being used.
         */
        $this->put('home.intro_title', array_filter([
            'id' => $this->cleanText(isset($row['title']) ? (string) $row['title'] : ''),
            'en' => $this->cleanText(isset($row['title_english']) ? (string) $row['title_english'] : ''),
        ], function ($value) {
            return $value !== '';
        }));

        $this->put('home.intro_body', [
            'id' => (string) $this->cleanHtml(isset($row['description']) ? $row['description'] : null),
            'en' => (string) $this->cleanHtml(isset($row['description_english']) ? $row['description_english'] : null),
        ], [
            $this->registerFile(isset($row['gambar']) ? (string) $row['gambar'] : null, 'images/about', 'image', $table),
            $this->registerFile(isset($row['gambar_2']) ? (string) $row['gambar_2'] : null, 'images/about', 'image', $table),
        ]);

        $this->count($table, 'updated', 1);
    }

    /**
     * @param array<string,string> $translations locale => text
     * @param array<int,int|null>  $media        [media_id, media_2_id]
     */
    private function put(string $key, array $translations, array $media = []): void
    {
        $setting = $this->db->selectOne('SELECT id FROM site_settings WHERE `key` = ? LIMIT 1', [$key]);

        if ($setting === null) {
            $this->note(sprintf('setting %s is not declared in the schema, skipped', $key));
            return;
        }

        $id = (int) $setting['id'];

        $this->db->affected(
            'UPDATE site_settings SET media_id = ?, media_2_id = ?, updated_at = ? WHERE id = ?',
            [
                isset($media[0]) ? $media[0] : null,
                isset($media[1]) ? $media[1] : null,
                date('Y-m-d H:i:s'),
                $id,
            ]
        );

        foreach ($translations as $locale => $value) {
            $this->db->run(
                'INSERT INTO site_setting_translations (setting_id, locale, value)
                 VALUES (?, ?, ?)
                 ON DUPLICATE KEY UPDATE value = VALUES(value)',
                [$id, $locale, $value]
            );
        }
    }
}
