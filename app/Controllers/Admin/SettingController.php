<?php

namespace Mktr\Controllers\Admin;

use Mktr\Core\Config;
use Mktr\Core\Html;
use Mktr\Core\Response;
use Mktr\Core\Session;
use Mktr\Models\Media;
use Mktr\Models\Setting;

/**
 * Site-wide values: the home intro block, the office address, the social
 * links. In the legacy site the address and the social URLs were typed into
 * all 28 modules, so changing an office address meant a code deploy.
 *
 * Settings are declared in the schema and edited here — the screen never
 * creates or deletes rows, because a key the application does not read would
 * do nothing and a missing key would break a template.
 */
class SettingController extends AdminController
{
    /** Which keys carry rich text rather than a single line. */
    private static $richText = ['home.intro_body'];

    /** Which keys carry images, and how many. */
    private static $withMedia = ['home.intro_body' => 2];

    /** Keys whose value is the same in every locale. */
    private static $untranslated = [
        'contact.email', 'contact.phone',
        'social.instagram', 'social.youtube', 'social.facebook', 'social.linkedin',
    ];

    /** @var array<string,string> */
    private static $groupLabels = [
        'home'    => 'Beranda',
        'contact' => 'Kontak',
        'social'  => 'Media Sosial',
    ];

    /** @var array<string,string> */
    private static $keyLabels = [
        'home.intro_title' => 'Judul blok pembuka',
        'home.intro_body'  => 'Teks blok pembuka',
        'contact.address'  => 'Alamat kantor',
        'contact.email'    => 'Email',
        'contact.phone'    => 'Telepon',
        'social.instagram' => 'Instagram',
        'social.youtube'   => 'YouTube',
        'social.facebook'  => 'Facebook',
        'social.linkedin'  => 'LinkedIn',
    ];

    public function index(array $params): Response
    {
        $denied = $this->guard('content.edit');
        if ($denied !== null) {
            return $denied;
        }

        $settings = new Setting();
        $media    = new Media();
        $rows     = $settings->adminRows();

        foreach ($rows as $index => $row) {
            $rows[$index]['media']   = $row['media_id'] !== null ? $media->find((int) $row['media_id']) : null;
            $rows[$index]['media_2'] = $row['media_2_id'] !== null ? $media->find((int) $row['media_2_id']) : null;
        }

        return $this->adminView('admin.settings.index', [
            'title'        => 'Pengaturan Situs — CMS MKTR',
            'rows'         => $rows,
            'translations' => $settings->allTranslations(),
            'groupLabels'  => self::$groupLabels,
            'keyLabels'    => self::$keyLabels,
            'richText'     => self::$richText,
            'withMedia'    => self::$withMedia,
            'untranslated' => self::$untranslated,
        ]);
    }

    public function update(array $params): Response
    {
        $denied = $this->guard('content.edit');
        if ($denied !== null) {
            return $denied;
        }

        $invalid = $this->verifyCsrf();
        if ($invalid !== null) {
            return $invalid;
        }

        $settings = new Setting();
        $locales  = (array) Config::get('app.locales', ['id']);

        foreach ($settings->adminRows() as $row) {
            $id  = (int) $row['id'];
            $key = (string) $row['key'];

            $translations = [];

            if (!in_array($key, self::$untranslated, true)) {
                foreach ($locales as $code) {
                    $field = 'value_' . $id . '_' . $code;
                    $raw   = (string) $this->request->input($field, '');

                    $translations[$code] = in_array($key, self::$richText, true)
                        ? Html::sanitize($raw)
                        : strip_tags($raw);
                }
            }

            $value = in_array($key, self::$untranslated, true)
                ? $this->request->text('value_' . $id)
                : null;

            $slots = isset(self::$withMedia[$key]) ? (int) self::$withMedia[$key] : 0;
            $one   = $slots >= 1 ? $this->request->int('media_' . $id, 0) : 0;
            $two   = $slots >= 2 ? $this->request->int('media_2_' . $id, 0) : 0;

            $settings->save(
                $id,
                $value === '' ? null : $value,
                $one > 0 ? $one : null,
                $two > 0 ? $two : null,
                $translations
            );
        }

        Session::flash('success', 'Pengaturan berhasil disimpan.');

        return $this->redirect($this->route('admin.settings.index'));
    }
}
