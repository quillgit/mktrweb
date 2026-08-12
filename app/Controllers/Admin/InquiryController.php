<?php

namespace Mktr\Controllers\Admin;

use Mktr\Core\Paginator;
use Mktr\Core\Response;
use Mktr\Core\Session;
use Mktr\Models\Inquiry;

/**
 * The inbox for the public forms — contact, grievance and whistleblower.
 *
 * Submissions are never rendered on the site; this screen is the only reader.
 * Reading a submission marks it read, which is the whole workflow: there is
 * nothing here that edits what a member of the public wrote.
 */
class InquiryController extends AdminController
{
    /** @var array<string,string> */
    private static $kindLabels = [
        'contact'       => 'Kontak',
        'grievance'     => 'Pengaduan',
        'whistleblower' => 'Pelaporan Pelanggaran',
    ];

    /** @var array<string,string> */
    private static $statusLabels = [
        'new'      => 'Baru',
        'read'     => 'Dibaca',
        'archived' => 'Diarsipkan',
    ];

    /** Readable names for the form-specific fields kept in `payload`. */
    private static $payloadLabels = [
        'reported_name'     => 'Nama terlapor',
        'reported_position' => 'Jabatan terlapor',
        'occurred_at'       => 'Waktu kejadian',
        'location'          => 'Lokasi kejadian',
        'amount'            => 'Nilai kerugian',
        'organization'      => 'Organisasi',
        'address'           => 'Alamat',
        'communication'     => 'Saluran komunikasi',
    ];

    public function index(array $params): Response
    {
        $denied = $this->guard('content.view');
        if ($denied !== null) {
            return $denied;
        }

        $inquiries = new Inquiry();
        $kind      = $this->request->text('kind');
        $kind      = isset(self::$kindLabels[$kind]) ? $kind : '';
        $status    = $this->request->text('status');
        $status    = isset(self::$statusLabels[$status]) ? $status : '';

        $query = [];
        if ($kind !== '') {
            $query[] = 'kind=' . $kind;
        }
        if ($status !== '') {
            $query[] = 'status=' . $status;
        }

        $paginator = new Paginator(
            $inquiries->adminCount($kind, $status),
            30,
            max(1, $this->request->int('page', 1)),
            $this->route('admin.inquiries.index') . ($query === [] ? '' : '?' . implode('&', $query))
        );

        return $this->adminView('admin.inquiries.index', [
            'title'        => 'Formulir & Pesan — CMS MKTR',
            'rows'         => $inquiries->adminPage($paginator->perPage(), $paginator->offset(), $kind, $status),
            'paginator'    => $paginator,
            'kind'         => $kind,
            'status'       => $status,
            'kindLabels'   => self::$kindLabels,
            'statusLabels' => self::$statusLabels,
            'unread'       => $inquiries->adminCount('', 'new'),
        ]);
    }

    public function show(array $params): Response
    {
        $denied = $this->guard('content.view');
        if ($denied !== null) {
            return $denied;
        }

        $inquiries = new Inquiry();
        $inquiry   = $inquiries->find((int) $params['id']);

        if ($inquiry === null) {
            return $this->notFound();
        }

        // Opening a submission is what marks it read.
        $inquiries->markRead((int) $inquiry['id']);

        return $this->adminView('admin.inquiries.show', [
            'title'         => 'Pesan — CMS MKTR',
            'inquiry'       => $inquiry,
            'payload'       => $inquiries->decodePayload($inquiry['payload']),
            'payloadLabels' => self::$payloadLabels,
            'kindLabels'    => self::$kindLabels,
            'statusLabels'  => self::$statusLabels,
        ]);
    }

    public function destroy(array $params): Response
    {
        $denied = $this->guard('content.delete');
        if ($denied !== null) {
            return $denied;
        }

        $invalid = $this->verifyCsrf();
        if ($invalid !== null) {
            return $invalid;
        }

        (new Inquiry())->delete((int) $params['id']);

        Session::flash('success', 'Pesan berhasil dihapus.');

        return $this->redirect($this->route('admin.inquiries.index'));
    }
}
