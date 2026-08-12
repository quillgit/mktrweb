<?php
/**
 * Route table and dispatcher.
 *
 * Routes are declared once in config/routes.php. Locale is a URL prefix rather
 * than a separate copy of the site: the default locale (id) lives at the root
 * and every other locale sits under /{code}/…, so `/berita` and `/en/berita`
 * reach the same controller. That is what replaces the en/ fork.
 */

namespace Mktr\Core;

class Router
{
    /** @var array<int,array> */
    private $routes = [];

    /** @var array<string,string> name => pattern */
    private $names = [];

    /** @var string */
    private $locale = '';

    public function add(string $method, string $pattern, $handler, ?string $name = null): void
    {
        $pattern = '/' . trim($pattern, '/');
        if ($pattern !== '/') {
            $pattern = rtrim($pattern, '/');
        }

        $this->routes[] = [
            'method'  => strtoupper($method),
            'pattern' => $pattern,
            'handler' => $handler,
            'name'    => $name,
        ];

        if ($name !== null) {
            $this->names[$name] = $pattern;
        }
    }

    public function get(string $pattern, $handler, ?string $name = null): void
    {
        $this->add('GET', $pattern, $handler, $name);
    }

    public function post(string $pattern, $handler, ?string $name = null): void
    {
        $this->add('POST', $pattern, $handler, $name);
    }

    public function locale(): string
    {
        return $this->locale !== '' ? $this->locale : (string) Config::get('app.default_locale', 'id');
    }

    /**
     * Strip a leading locale segment and remember it.
     */
    private function extractLocale(string $path): string
    {
        $locales = (array) Config::get('app.locales', ['id']);
        $default = (string) Config::get('app.default_locale', 'id');

        $this->locale = $default;

        foreach ($locales as $code) {
            if ($code === $default) {
                continue;
            }

            if ($path === '/' . $code) {
                $this->locale = $code;
                return '/';
            }

            if (strpos($path, '/' . $code . '/') === 0) {
                $this->locale = $code;
                return substr($path, strlen($code) + 1);
            }
        }

        return $path;
    }

    /**
     * @return array{handler:mixed,params:array<string,string>}|null
     */
    public function match(string $method, string $path): ?array
    {
        $path   = $this->extractLocale($path);
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $regex  = $this->toRegex($route['pattern']);
            $values = [];

            if (preg_match($regex, $path, $values) === 1) {
                $params = [];
                foreach ($values as $key => $value) {
                    if (!is_int($key)) {
                        $params[$key] = $value;
                    }
                }

                return ['handler' => $route['handler'], 'params' => $params];
            }
        }

        return null;
    }

    /**
     * `/read/{id}/{slug}` becomes a named-group regex. {id} is numeric-only.
     */
    private function toRegex(string $pattern): string
    {
        $regex = preg_replace_callback(
            '#\{([a-z_]+)\}#i',
            function (array $m) {
                $name = $m[1];
                $char = ($name === 'id' || substr($name, -3) === '_id') ? '\d' : '[^/]';

                return '(?P<' . $name . '>' . $char . '+)';
            },
            $pattern
        );

        return '#^' . $regex . '$#u';
    }

    /**
     * Build a URL for a named route, prefixing the locale when it is not the default.
     */
    public function url(string $name, array $params = [], ?string $locale = null): string
    {
        if (!isset($this->names[$name])) {
            return '/';
        }

        $path = $this->names[$name];

        foreach ($params as $key => $value) {
            $path = str_replace('{' . $key . '}', rawurlencode((string) $value), $path);
        }

        $locale  = $locale !== null ? $locale : $this->locale();
        $default = (string) Config::get('app.default_locale', 'id');

        if ($locale !== $default) {
            $path = '/' . $locale . ($path === '/' ? '' : $path);
        }

        $base = (string) Config::get('app.base_path', '');

        return ($base === '' ? '' : rtrim($base, '/')) . ($path === '' ? '/' : $path);
    }
}
