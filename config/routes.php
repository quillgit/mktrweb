<?php
/**
 * Route table.
 *
 * Patterns reproduce the legacy sitemap exactly (see SPEC.md §4), so existing
 * URLs keep working. Locale is handled by the Router as a prefix: every route
 * below is reachable both at `/berita` (id) and `/en/berita` (en).
 *
 * Routes marked TODO are part of later phases; this pass ships the News slice.
 */

use Mktr\Core\Router;

return function (Router $router) {

    /* ---- front: news (this pass) ---------------------------------------- */

    $router->get('/berita', 'Mktr\Controllers\Front\NewsController@index', 'news.index');
    $router->get('/berita/{page}', 'Mktr\Controllers\Front\NewsController@index', 'news.page');
    $router->get('/read/{id}/{slug}', 'Mktr\Controllers\Front\NewsController@show', 'news.show');

    // Signed preview of unpublished content.
    $router->get('/preview/{token}', 'Mktr\Controllers\Front\PreviewController@show', 'preview.show');

    /* ---- front: content pages ------------------------------------------- */
    /*
     * The seven `about` pages are fixed paths in the legacy sitemap rather than
     * a slug pattern, so they are registered individually. The controller reads
     * the slug from the path.
     */
    foreach (['profil_kami', 'logo_kami', 'visi_misi', 'struktur_kepemilikan',
              'struktur_group', 'struktur_organisasi'] as $aboutSlug) {
        $router->get('/' . $aboutSlug, 'Mktr\Controllers\Front\PageController@about', 'pages.' . $aboutSlug);
    }

    /* ---- front: about collections ---------------------------------------- */
    /*
     * These seven paths belong to the about section but are backed by
     * collection_items rather than a page row, exactly as in the legacy site:
     * /keanggotaan renders tabel_keanggotaan (the about_us row of the same
     * slug is only its intro prose), not a content page.
     */
    $router->get('/peristiwa_penting', 'Mktr\Controllers\Front\CollectionController@milestones', 'collections.milestones');
    $router->get('/dewan_komisaris', 'Mktr\Controllers\Front\CollectionController@commissioners', 'collections.commissioners');
    $router->get('/direksi', 'Mktr\Controllers\Front\CollectionController@directors', 'collections.directors');
    $router->get('/mktr_so/{slug}', 'Mktr\Controllers\Front\CollectionController@person', 'collections.person');
    $router->get('/anak_perusahaan_kami', 'Mktr\Controllers\Front\CollectionController@subsidiaries', 'collections.subsidiaries');
    $router->get('/penghargaan', 'Mktr\Controllers\Front\CollectionController@awards', 'collections.awards');
    $router->get('/keanggotaan', 'Mktr\Controllers\Front\CollectionController@memberships', 'collections.memberships');

    $router->get('/bisnis/{slug}', 'Mktr\Controllers\Front\PageController@business', 'pages.business');
    $router->get('/keberlanjutan/{slug}', 'Mktr\Controllers\Front\PageController@sustainability', 'pages.sustainability');
    $router->get('/tatakelola_perusahaan/{slug}', 'Mktr\Controllers\Front\PageController@governance', 'pages.governance');
    $router->get('/sdm/{slug}', 'Mktr\Controllers\Front\PageController@hr', 'pages.hr');

    /*
     * Investor pages resolve through PageController, not straight to documents:
     * production data shows these pages carry `tipe` = text or dokumen, so the
     * page decides whether to render prose or a document listing.
     */
    $router->get('/hubungan_investor/{slug}', 'Mktr\Controllers\Front\PageController@investor', 'pages.investor');

    /* ---- front: documents & careers -------------------------------------- */

    $router->get('/dokumen/{id}/{slug}', 'Mktr\Controllers\Front\DocumentController@download', 'documents.download');

    $router->get('/karir', 'Mktr\Controllers\Front\CareerController@index', 'careers.index');
    $router->get('/apply/{id}/{slug}', 'Mktr\Controllers\Front\CareerController@show', 'careers.show');

    /* ---- admin ----------------------------------------------------------- */

    $router->get('/admin/login', 'Mktr\Controllers\Admin\AuthController@showLogin', 'admin.login');
    $router->post('/admin/login', 'Mktr\Controllers\Admin\AuthController@login', 'admin.login.post');
    $router->post('/admin/logout', 'Mktr\Controllers\Admin\AuthController@logout', 'admin.logout');

    $router->get('/admin', 'Mktr\Controllers\Admin\DashboardController@index', 'admin.dashboard');

    $router->get('/admin/posts', 'Mktr\Controllers\Admin\PostController@index', 'admin.posts.index');
    $router->get('/admin/posts/create', 'Mktr\Controllers\Admin\PostController@create', 'admin.posts.create');
    $router->post('/admin/posts', 'Mktr\Controllers\Admin\PostController@store', 'admin.posts.store');
    $router->get('/admin/posts/{id}/edit', 'Mktr\Controllers\Admin\PostController@edit', 'admin.posts.edit');
    $router->post('/admin/posts/{id}', 'Mktr\Controllers\Admin\PostController@update', 'admin.posts.update');
    $router->post('/admin/posts/{id}/delete', 'Mktr\Controllers\Admin\PostController@destroy', 'admin.posts.destroy');
    $router->get('/admin/posts/{id}/revisions', 'Mktr\Controllers\Admin\PostController@revisions', 'admin.posts.revisions');
    $router->post('/admin/posts/{id}/revisions/{revision_id}/restore', 'Mktr\Controllers\Admin\PostController@restore', 'admin.posts.restore');

    $router->get('/admin/pages', 'Mktr\Controllers\Admin\PageController@index', 'admin.pages.index');
    $router->get('/admin/pages/create', 'Mktr\Controllers\Admin\PageController@create', 'admin.pages.create');
    $router->post('/admin/pages', 'Mktr\Controllers\Admin\PageController@store', 'admin.pages.store');
    $router->get('/admin/pages/{id}/edit', 'Mktr\Controllers\Admin\PageController@edit', 'admin.pages.edit');
    $router->post('/admin/pages/{id}', 'Mktr\Controllers\Admin\PageController@update', 'admin.pages.update');
    $router->post('/admin/pages/{id}/delete', 'Mktr\Controllers\Admin\PageController@destroy', 'admin.pages.destroy');

    $router->get('/admin/careers', 'Mktr\Controllers\Admin\CareerController@index', 'admin.careers.index');
    $router->get('/admin/careers/create', 'Mktr\Controllers\Admin\CareerController@create', 'admin.careers.create');
    $router->post('/admin/careers', 'Mktr\Controllers\Admin\CareerController@store', 'admin.careers.store');
    $router->get('/admin/careers/{id}/edit', 'Mktr\Controllers\Admin\CareerController@edit', 'admin.careers.edit');
    $router->post('/admin/careers/{id}', 'Mktr\Controllers\Admin\CareerController@update', 'admin.careers.update');
    $router->post('/admin/careers/{id}/delete', 'Mktr\Controllers\Admin\CareerController@destroy', 'admin.careers.destroy');

    $router->get('/admin/collections', 'Mktr\Controllers\Admin\CollectionController@index', 'admin.collections.index');
    $router->get('/admin/collections/create', 'Mktr\Controllers\Admin\CollectionController@create', 'admin.collections.create');
    $router->post('/admin/collections', 'Mktr\Controllers\Admin\CollectionController@store', 'admin.collections.store');
    $router->get('/admin/collections/{id}/edit', 'Mktr\Controllers\Admin\CollectionController@edit', 'admin.collections.edit');
    $router->post('/admin/collections/{id}', 'Mktr\Controllers\Admin\CollectionController@update', 'admin.collections.update');
    $router->post('/admin/collections/{id}/delete', 'Mktr\Controllers\Admin\CollectionController@destroy', 'admin.collections.destroy');

    $router->get('/admin/documents', 'Mktr\Controllers\Admin\DocumentController@index', 'admin.documents.index');
    $router->get('/admin/documents/create', 'Mktr\Controllers\Admin\DocumentController@create', 'admin.documents.create');
    $router->post('/admin/documents', 'Mktr\Controllers\Admin\DocumentController@store', 'admin.documents.store');
    $router->get('/admin/documents/{id}/edit', 'Mktr\Controllers\Admin\DocumentController@edit', 'admin.documents.edit');
    $router->post('/admin/documents/{id}', 'Mktr\Controllers\Admin\DocumentController@update', 'admin.documents.update');
    $router->post('/admin/documents/{id}/delete', 'Mktr\Controllers\Admin\DocumentController@destroy', 'admin.documents.destroy');

    $router->get('/admin/inquiries', 'Mktr\Controllers\Admin\InquiryController@index', 'admin.inquiries.index');
    $router->get('/admin/inquiries/{id}', 'Mktr\Controllers\Admin\InquiryController@show', 'admin.inquiries.show');
    $router->post('/admin/inquiries/{id}/delete', 'Mktr\Controllers\Admin\InquiryController@destroy', 'admin.inquiries.destroy');

    $router->get('/admin/media', 'Mktr\Controllers\Admin\MediaController@index', 'admin.media.index');
    $router->post('/admin/media', 'Mktr\Controllers\Admin\MediaController@store', 'admin.media.store');
    $router->post('/admin/media/{id}/delete', 'Mktr\Controllers\Admin\MediaController@destroy', 'admin.media.destroy');
    // JSON endpoint backing the editor's media picker.
    $router->get('/admin/media/browse', 'Mktr\Controllers\Admin\MediaController@browse', 'admin.media.browse');

    /*
     * TODO (P2) — remaining legacy routes, ported once the News slice is
     * reviewed. Patterns are recorded here so the sitemap stays visible:
     *
     *   /                              home
     *   /kontak_kami /form_grievance /pelaporan_pelanggaran
     *   /pencarian /cari/{slug}
     */
};
