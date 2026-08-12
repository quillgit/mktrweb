<?php

namespace Mktr\Controllers\Front;

use Mktr\Core\Config;
use Mktr\Core\Controller;
use Mktr\Core\Response;
use Mktr\Core\Session;
use Mktr\Core\Validator;
use Mktr\Models\Grievance;
use Mktr\Models\Inquiry;
use Mktr\Models\Page;
use Mktr\Support\SectionMenu;

/**
 * The three public forms.
 *
 * In the legacy site these were three different things wearing the same coat:
 *
 *   /kontak_kami          had no <form> tag at all — the fields had no `name`
 *                         attributes and "Kirim Pesan" was an <a href="#">.
 *                         Nothing a visitor typed there was ever received.
 *   /form_grievance       posted to itself and interpolated every field into
 *                         an INSERT string.
 *   /pelaporan_pelanggaran the same, plus a second INSERT per checkbox.
 *
 * Here all three post to a named route, are CSRF-checked, validated, rate
 * limited per IP, and written through prepared statements. Grievances go to
 * `grievances` (unpublished, exactly as the legacy handler wrote them) and the
 * other two to `inquiries`.
 */
class FormController extends Controller
{
    /** Submissions allowed from one IP address per hour, across all forms. */
    const RATE_LIMIT = 5;

    /** Value the honeypot field must have — it is hidden, so always empty. */
    const HONEYPOT = 'website';

    /** @var string[] translation keys for the whistleblower checkboxes */
    private static $reportCategories = [
        'whistle.cat.fraud',
        'whistle.cat.ethics',
        'whistle.cat.authority',
        'whistle.cat.legal',
        'whistle.cat.safety',
        'whistle.cat.other',
    ];

    /* ---- contact --------------------------------------------------------- */

    public function contact(array $params): Response
    {
        return $this->form('front.forms.contact', $this->context('contact.title', 'contact', [
            'subjects' => [
                __('contact.subject.corporate'),
                __('contact.subject.secretary'),
                __('contact.subject.investor'),
            ],
        ]));
    }

    public function submitContact(array $params): Response
    {
        $invalid = $this->verifyCsrf();
        if ($invalid !== null) {
            return $invalid;
        }

        $redirect = $this->route('forms.contact');

        $rejected = $this->rejectAbuse($redirect);
        if ($rejected !== null) {
            return $rejected;
        }

        $input = [
            'subject' => $this->request->text('subject'),
            'name'    => $this->request->text('name'),
            'company' => $this->request->text('company'),
            'phone'   => $this->request->text('phone'),
            'email'   => $this->request->text('email'),
            'message' => $this->request->text('message'),
        ];

        $validator = new Validator($input, [
            'subject' => __('contact.subject'),
            'name'    => __('contact.name'),
            'phone'   => __('contact.phone'),
            'email'   => __('contact.email'),
            'message' => __('contact.message'),
        ]);

        $valid = $validator->validate([
            'subject' => 'required|max:255',
            'name'    => 'required|max:191',
            'company' => 'nullable|max:191',
            'phone'   => 'nullable|max:40',
            'email'   => 'required|email|max:191',
            'message' => 'required|min:10|max:5000',
        ]);

        if (!$valid) {
            return $this->rejected($validator->firstErrors(), $input, $redirect);
        }

        (new Inquiry())->record(
            'contact',
            $input,
            $input['company'] !== '' ? ['company' => $input['company']] : [],
            $this->request->ip(),
            $this->request->userAgent()
        );

        Session::flash('success', __('contact.success'));

        return $this->redirect($redirect);
    }

    /* ---- grievance ------------------------------------------------------- */

    public function grievance(array $params): Response
    {
        return $this->form('front.forms.grievance', $this->context('grievance.title', 'grievance'));
    }

    public function submitGrievance(array $params): Response
    {
        $invalid = $this->verifyCsrf();
        if ($invalid !== null) {
            return $invalid;
        }

        $redirect = $this->route('forms.grievance');

        $rejected = $this->rejectAbuse($redirect);
        if ($rejected !== null) {
            return $rejected;
        }

        $input = [
            'name'          => $this->request->text('name'),
            'organization'  => $this->request->text('organization'),
            'address'       => $this->request->text('address'),
            'email'         => $this->request->text('email'),
            'phone'         => $this->request->text('phone'),
            'communication' => $this->request->text('communication'),
        ];

        $validator = new Validator($input, [
            'name'          => __('grievance.name'),
            'organization'  => __('grievance.occupation'),
            'address'       => __('grievance.address'),
            'email'         => __('grievance.email'),
            'phone'         => __('grievance.phone'),
            'communication' => __('grievance.language'),
        ]);

        $valid = $validator->validate([
            'name'          => 'required|max:150',
            'organization'  => 'required|max:150',
            'address'       => 'required|max:2000',
            'email'         => 'required|email|max:150',
            'phone'         => 'required|max:30',
            'communication' => 'required|max:255',
        ]);

        if (!$valid) {
            return $this->rejected($validator->firstErrors(), $input, $redirect);
        }

        (new Grievance())->record($input, $this->request->ip(), $this->request->userAgent());

        Session::flash('success', __('grievance.success'));

        return $this->redirect($redirect);
    }

    /* ---- whistleblower --------------------------------------------------- */

    public function whistleblower(array $params): Response
    {
        return $this->form('front.forms.whistleblower', $this->context('whistle.title', 'whistleblower', [
            'categories' => array_map('__', self::$reportCategories),
        ]));
    }

    public function submitWhistleblower(array $params): Response
    {
        $invalid = $this->verifyCsrf();
        if ($invalid !== null) {
            return $invalid;
        }

        $redirect = $this->route('forms.whistleblower');

        $rejected = $this->rejectAbuse($redirect);
        if ($rejected !== null) {
            return $rejected;
        }

        $input = [
            'name'              => $this->request->text('name'),
            'phone'             => $this->request->text('phone'),
            'email'             => $this->request->text('email'),
            'reported_name'     => $this->request->text('reported_name'),
            'reported_position' => $this->request->text('reported_position'),
            'occurred_at'       => $this->request->text('occurred_at'),
            'location'          => $this->request->text('location'),
            'message'           => $this->request->text('message'),
            'amount'            => $this->request->text('amount'),
        ];

        $validator = new Validator($input, [
            'name'          => __('whistle.reporter_name'),
            'phone'         => __('whistle.reporter_phone'),
            'email'         => __('whistle.reporter_email'),
            'reported_name' => __('whistle.reported_name'),
            'occurred_at'   => __('whistle.occurred_at'),
            'location'      => __('whistle.location'),
            'message'       => __('whistle.chronology'),
            'amount'        => __('whistle.amount'),
        ]);

        $valid = $validator->validate([
            'name'              => 'nullable|max:191',
            'phone'             => 'required|max:40',
            'email'             => 'required|email|max:191',
            'reported_name'     => 'required|max:191',
            'reported_position' => 'nullable|max:191',
            'occurred_at'       => 'required|date',
            'location'          => 'required|max:255',
            'message'           => 'required|min:20|max:8000',
            'amount'            => 'nullable|int',
        ]);

        if (!$valid) {
            return $this->rejected($validator->firstErrors(), $input, $redirect);
        }

        /*
         * Only the categories actually offered are accepted, so a crafted POST
         * cannot write arbitrary strings into the payload.
         */
        $offered   = array_map('__', self::$reportCategories);
        $submitted = (array) $this->request->input('categories', []);
        $chosen    = [];

        foreach ($submitted as $value) {
            if (is_string($value) && in_array($value, $offered, true)) {
                $chosen[] = $value;
            }
        }

        $payload = [
            'reported_name'     => $input['reported_name'],
            'reported_position' => $input['reported_position'],
            'occurred_at'       => $input['occurred_at'],
            'location'          => $input['location'],
            'amount'            => $input['amount'],
            'categories'        => $chosen,
        ];

        $payload = array_filter($payload, function ($value) {
            return $value !== null && $value !== '' && $value !== [];
        });

        (new Inquiry())->record(
            'whistleblower',
            ['name' => $input['name'], 'email' => $input['email'], 'phone' => $input['phone'],
             'subject' => null, 'message' => $input['message']],
            $payload,
            $this->request->ip(),
            $this->request->userAgent()
        );

        Session::flash('success', __('whistle.success'));

        return $this->redirect($redirect);
    }

    /* ---- shared ---------------------------------------------------------- */

    /**
     * @param  array<string,mixed> $extra
     * @return array<string,mixed>
     */
    private function context(string $titleKey, string $form, array $extra = []): array
    {
        $locale   = $this->router->locale();
        $fallback = (string) Config::get('app.default_locale', 'id');
        $pages    = new Page();

        /*
         * The grievance form sits inside the sustainability section in the
         * legacy sitemap, next to the public register; the other two stand on
         * their own.
         */
        $section = $form === 'grievance' ? 'sustainability' : '';

        $data = array_merge([
            'form'            => $form,
            'section'         => $section,
            'page'            => ['id' => 0, 'title' => __($titleKey), 'subtitle' => null, 'banner_path' => null],
            'navItems'        => $section === ''
                ? []
                : SectionMenu::forSection($this->router, $section, $pages->sectionTree($section, $locale, $fallback)),
            'activeKey'       => '',
            'title'           => __($titleKey) . ' — ' . __('site.name'),
            'metaDescription' => __($titleKey) . ' — ' . __('site.name'),
            'canonical'       => $this->route('forms.' . $form),
            'success'         => Session::pull('success', ''),
            'error'           => Session::pull('error', ''),
            'formErrors'      => Session::pull('errors', []),
        ], $extra);

        return $data;
    }

    /**
     * Old input is cleared only after the view has read it, so a rejected
     * submission comes back with the visitor's answers still in the fields.
     *
     * @param array<string,mixed> $data
     */
    private function form(string $template, array $data): Response
    {
        $response = $this->view($template, $data);

        Session::clearOldInput();

        return $response;
    }

    /**
     * Cheap abuse defences that cost a legitimate visitor nothing: a hidden
     * field bots fill in, and a per-IP hourly cap across all three forms.
     */
    private function rejectAbuse(string $redirect): ?Response
    {
        if ($this->request->text(self::HONEYPOT) !== '') {
            // Report success to the bot rather than telling it what tripped.
            Session::flash('success', __('contact.success'));

            return $this->redirect($redirect);
        }

        $ip    = $this->request->ip();
        $since = date('Y-m-d H:i:s', time() - 3600);
        $count = (new Inquiry())->countFromIpSince($ip, $since)
               + (new Grievance())->countFromIpSince($ip, $since);

        if ($count >= self::RATE_LIMIT) {
            Session::flash('error', __('form.throttled'));

            return $this->redirect($redirect);
        }

        return null;
    }

    /**
     * @param array<string,string> $errors
     * @param array<string,mixed>  $input
     */
    private function rejected(array $errors, array $input, string $redirect): Response
    {
        $this->withErrors($errors, $input);
        Session::flash('error', __('form.error'));

        return $this->redirect($redirect);
    }
}
