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
     *   /profil_kami /logo_kami /visi_misi /peristiwa_penting
     *   /struktur_kepemilikan /struktur_organisasi /dewan_komisaris /direksi
     *   /struktur_group /anak_perusahaan_kami /penghargaan /keanggotaan
     *   /bisnis/{slug} /keberlanjutan/{slug} /tatakelola_perusahaan/{slug}
     *   /sdm/{slug} /hubungan_investor/{slug} /mktr_so/{slug}
     *   /karir /apply/{id}/{slug} /kontak_kami /form_grievance
     *   /pelaporan_pelanggaran /pencarian /cari/{slug}
     */
};
