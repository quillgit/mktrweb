<?php
/**
 * Application kernel: resolve a route, run the controller, return a Response.
 */

namespace Mktr\Core;

class App
{
    /** @var Router */
    private $router;

    /** @var Request */
    private $request;

    public function __construct(Router $router, Request $request)
    {
        $this->router  = $router;
        $this->request = $request;
    }

    public function handle(): Response
    {
        // Shared before anything can throw, so the error views can still render.
        View::share('router', $this->router);
        View::share('request', $this->request);
        View::share('locale', (string) Config::get('app.default_locale', 'id'));

        try {
            $match = $this->router->match($this->request->method(), $this->request->path());

            // Locale is only known after matching, since it is a URL prefix.
            Lang::setLocale($this->router->locale());
            View::share('locale', $this->router->locale());

            if ($match === null) {
                return $this->renderError(404, 'front.errors.404');
            }

            return $this->run($match['handler'], $match['params']);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    /**
     * @param mixed $handler 'Namespace\Class@method' or a closure
     */
    private function run($handler, array $params): Response
    {
        if (is_callable($handler)) {
            $result = $handler($this->request, $params);

            return $result instanceof Response ? $result : Response::html((string) $result);
        }

        if (!is_string($handler) || strpos($handler, '@') === false) {
            throw new \RuntimeException('Invalid route handler.');
        }

        list($class, $method) = explode('@', $handler, 2);

        if (!class_exists($class)) {
            throw new \RuntimeException('Controller not found: ' . $class);
        }

        $controller = new $class($this->request, $this->router);

        if (!method_exists($controller, $method)) {
            throw new \RuntimeException('Action not found: ' . $class . '::' . $method);
        }

        $result = $controller->{$method}($params);

        return $result instanceof Response ? $result : Response::html((string) $result);
    }

    private function handleException(\Throwable $e): Response
    {
        $this->log($e);

        if ((bool) Config::get('app.debug', false)) {
            $body = '<!doctype html><meta charset="utf-8">'
                . '<style>body{font:14px/1.6 ui-monospace,monospace;padding:32px;background:#101613;color:#e6ede9}'
                . 'h1{font-size:18px;color:#ff8f8f;margin:0 0 4px}pre{white-space:pre-wrap;color:#9fb3a8}'
                . 'code{color:#E5B455}</style>'
                . '<h1>' . e(get_class($e)) . '</h1>'
                . '<p><code>' . e($e->getMessage()) . '</code></p>'
                . '<p>' . e($e->getFile()) . ':' . (int) $e->getLine() . '</p>'
                . '<pre>' . e($e->getTraceAsString()) . '</pre>';

            return Response::html($body, 500);
        }

        return $this->renderError(500, 'front.errors.500');
    }

    private function renderError(int $status, string $template): Response
    {
        try {
            return Response::html(View::render($template), $status);
        } catch (\Throwable $e) {
            return Response::html('<h1>' . $status . '</h1>', $status);
        }
    }

    private function log(\Throwable $e): void
    {
        $path = Config::get('app.log_path', '');

        if (!is_string($path) || $path === '') {
            return;
        }

        if (!is_dir($path) && !mkdir($path, 0755, true) && !is_dir($path)) {
            return;
        }

        $line = sprintf(
            "[%s] %s: %s in %s:%d\n%s\n\n",
            date('Y-m-d H:i:s'),
            get_class($e),
            $e->getMessage(),
            $e->getFile(),
            $e->getLine(),
            $e->getTraceAsString()
        );

        @file_put_contents($path . '/error-' . date('Y-m-d') . '.log', $line, FILE_APPEND | LOCK_EX);
    }
}
