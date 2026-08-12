<?php

namespace Mktr\Controllers\Admin;

use Mktr\Core\Auth;
use Mktr\Core\Controller;
use Mktr\Core\Response;
use Mktr\Core\Session;
use Mktr\Core\View;

/**
 * Base for every admin screen: authentication guard, permission guard, and the
 * shared view data the admin layout needs.
 */
abstract class AdminController extends Controller
{
    /**
     * Returns a redirect/deny Response when the request must not proceed, or
     * null when it may. Every admin action calls this first.
     */
    protected function guard(string $ability = 'content.view'): ?Response
    {
        if (!Auth::check($this->request)) {
            return $this->redirect($this->route('admin.login'));
        }

        if (!Auth::can($ability)) {
            return Response::html(
                View::render('admin.errors.forbidden', ['user' => Auth::user()]),
                403
            );
        }

        View::share('authUser', Auth::user());

        return null;
    }

    protected function adminView(string $template, array $data = [], int $status = 200): Response
    {
        $data['flashSuccess'] = Session::pull('success', '');
        $data['flashError']   = Session::pull('error', '');
        $data['formErrors']   = Session::pull('errors', []);

        $response = $this->view($template, $data, $status);

        Session::clearOldInput();

        // The admin panel must never be indexed or framed.
        return $response->withHeader('X-Robots-Tag', 'noindex, nofollow');
    }
}
