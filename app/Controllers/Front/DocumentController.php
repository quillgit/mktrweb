<?php

namespace Mktr\Controllers\Front;

use Mktr\Core\Config;
use Mktr\Core\Controller;
use Mktr\Core\Response;
use Mktr\Models\Document;
use Mktr\Models\DocumentCategory;

class DocumentController extends Controller
{
    /**
     * Investor Relations category page.
     *
     * Replaces the hardcoded if/else chain in module/hubungan_investor.php,
     * where each slug had its own block querying its own tabel_laporan_* table.
     * Here the slug resolves to a category row and the layout comes from data.
     */
    public function category(array $params): Response
    {
        $locale   = $this->router->locale();
        $fallback = (string) Config::get('app.default_locale', 'id');
        $slug     = isset($params['slug']) ? (string) $params['slug'] : '';

        $categories = new DocumentCategory();
        $category   = $categories->findBySlug($slug, $locale, $fallback);

        if ($category === null) {
            return $this->notFound();
        }

        $documents = new Document();
        $years     = $documents->publishedYears((int) $category['id']);

        // Only honour a year that actually has documents, so a crafted query
        // string cannot produce a confusing empty state.
        $year = $this->request->int('year', 0);
        $year = ($year > 0 && in_array($year, $years, true)) ? $year : null;

        $rows = $documents->publishedInCategory((int) $category['id'], $locale, $fallback, $year);

        return $this->view('front.documents.category', [
            'category'   => $category,
            'categories' => $categories->listing($locale, $fallback),
            'documents'  => $rows,
            'years'      => $years,
            'activeYear' => $year,
            'title'      => $category['name'] . ' — ' . __('site.name'),
            'metaDescription' => $category['description'] !== null && $category['description'] !== ''
                ? (string) $category['description']
                : $category['name'] . ' — ' . __('site.name'),
            'canonical'  => $this->route('documents.category', ['slug' => $category['slug']]),
        ]);
    }

    /**
     * Serve a document and count the download.
     *
     * The legacy site linked straight at /dokumen/<file>, so nobody could tell
     * which reports were actually read.
     */
    public function download(array $params): Response
    {
        $locale   = $this->router->locale();
        $fallback = (string) Config::get('app.default_locale', 'id');
        $id       = isset($params['id']) ? (int) $params['id'] : 0;

        $documents = new Document();
        $document  = $documents->findPublishedWithFile($id, $locale, $fallback);

        if ($document === null || empty($document['file_path'])) {
            return $this->notFound();
        }

        $documents->incrementDownloads($id);

        $absolute = BASE_DIR . $document['file_path'];

        // Fall back to a redirect when the file is served from somewhere this
        // process cannot read; the counter has already been recorded.
        if (!is_file($absolute) || !is_readable($absolute)) {
            return $this->redirect((string) $document['file_path']);
        }

        $filename = $this->downloadName($document);

        return (new Response((string) file_get_contents($absolute), 200, [
            'Content-Type'        => (string) $document['file_mime'],
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
            'Content-Length'      => (string) filesize($absolute),
            'Cache-Control'       => 'public, max-age=3600',
        ]));
    }

    /**
     * A readable filename built from the document title rather than the opaque
     * stored name.
     */
    private function downloadName(array $document): string
    {
        $title = (string) ($document['title'] !== null ? $document['title'] : 'dokumen');
        $slug  = str_slug($title);
        $slug  = $slug === '' ? 'dokumen' : $slug;

        return mb_substr($slug, 0, 120) . '.pdf';
    }
}
