<?php

namespace Mktr\Core;

class Request
{
    /** @var array */
    private $query;
    /** @var array */
    private $post;
    /** @var array */
    private $files;
    /** @var array */
    private $server;

    public function __construct(array $query, array $post, array $files, array $server)
    {
        $this->query  = $query;
        $this->post   = $post;
        $this->files  = $files;
        $this->server = $server;
    }

    public static function capture(): self
    {
        return new self($_GET, $_POST, $_FILES, $_SERVER);
    }

    public function method(): string
    {
        $method = isset($this->server['REQUEST_METHOD']) ? strtoupper($this->server['REQUEST_METHOD']) : 'GET';

        // Browsers only send GET/POST; allow forms to spoof PUT/PATCH/DELETE.
        if ($method === 'POST' && isset($this->post['_method'])) {
            $spoofed = strtoupper((string) $this->post['_method']);
            if (in_array($spoofed, ['PUT', 'PATCH', 'DELETE'], true)) {
                return $spoofed;
            }
        }

        return $method;
    }

    public function isPost(): bool
    {
        return $this->method() !== 'GET' && $this->method() !== 'HEAD';
    }

    /**
     * Path with query string and any subdirectory prefix stripped.
     */
    public function path(): string
    {
        $uri  = isset($this->server['REQUEST_URI']) ? $this->server['REQUEST_URI'] : '/';
        $path = parse_url($uri, PHP_URL_PATH);
        $path = $path === false || $path === null ? '/' : $path;

        $base = Config::get('app.base_path', '');
        if ($base !== '' && strpos($path, $base) === 0) {
            $path = substr($path, strlen($base));
        }

        $path = '/' . trim(rawurldecode($path), '/');

        return $path === '/' ? '/' : rtrim($path, '/');
    }

    /**
     * @param  mixed $default
     * @return mixed
     */
    public function query(string $key, $default = null)
    {
        return array_key_exists($key, $this->query) ? $this->query[$key] : $default;
    }

    /**
     * @param  mixed $default
     * @return mixed
     */
    public function input(string $key, $default = null)
    {
        if (array_key_exists($key, $this->post)) {
            return $this->post[$key];
        }

        return array_key_exists($key, $this->query) ? $this->query[$key] : $default;
    }

    public function text(string $key, string $default = ''): string
    {
        $value = $this->input($key, $default);

        return is_scalar($value) ? trim((string) $value) : $default;
    }

    public function int(string $key, int $default = 0): int
    {
        $value = $this->input($key, $default);

        return is_scalar($value) ? (int) $value : $default;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->post) || array_key_exists($key, $this->query);
    }

    public function all(): array
    {
        return array_merge($this->query, $this->post);
    }

    public function file(string $key): ?array
    {
        if (!isset($this->files[$key])) {
            return null;
        }

        $file = $this->files[$key];

        if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        return $file;
    }

    public function server(string $key, string $default = ''): string
    {
        return isset($this->server[$key]) ? (string) $this->server[$key] : $default;
    }

    public function ip(): string
    {
        return $this->server('REMOTE_ADDR', '0.0.0.0');
    }

    public function userAgent(): string
    {
        return $this->server('HTTP_USER_AGENT');
    }

    public function isSecure(): bool
    {
        return $this->server('HTTPS') !== '' && strtolower($this->server('HTTPS')) !== 'off';
    }
}
