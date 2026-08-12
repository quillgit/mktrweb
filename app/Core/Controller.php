<?php

namespace Mktr\Core;

abstract class Controller
{
    /** @var Request */
    protected $request;

    /** @var Router */
    protected $router;

    public function __construct(Request $request, Router $router)
    {
        $this->request = $request;
        $this->router  = $router;
    }

    protected function view(string $template, array $data = [], int $status = 200): Response
    {
        return Response::html(View::render($template, $data), $status);
    }

    protected function redirect(string $url, int $status = 302): Response
    {
        return Response::redirect($url, $status);
    }

    protected function route(string $name, array $params = [], ?string $locale = null): string
    {
        return $this->router->url($name, $params, $locale);
    }

    protected function back(string $fallback = '/'): Response
    {
        $referer = $this->request->server('HTTP_REFERER');

        // Only follow a same-host referer, never an absolute off-site URL.
        if ($referer !== '') {
            $host = parse_url($referer, PHP_URL_HOST);
            if ($host === null || $host === $this->request->server('HTTP_HOST')) {
                return $this->redirect($referer);
            }
        }

        return $this->redirect($fallback);
    }

    protected function notFound(): Response
    {
        return Response::html(View::render('front.errors.404'), 404);
    }

    /**
     * Reject any non-GET request without a valid CSRF token.
     */
    protected function verifyCsrf(): ?Response
    {
        if (!$this->request->isPost()) {
            return null;
        }

        $token = $this->request->input('_token');

        if (!Csrf::check(is_string($token) ? $token : null)) {
            return Response::html(View::render('front.errors.419'), 419);
        }

        return null;
    }

    protected function withErrors(array $errors, array $input = []): void
    {
        Session::flash('errors', $errors);
        Session::flashInput($input);
    }
}
