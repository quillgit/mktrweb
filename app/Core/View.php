<?php
/**
 * Plain-PHP template renderer with layout support.
 *
 * A template opts into a layout by declaring `$layout = 'layouts.front';` at
 * the top. The renderer picks that variable up after inclusion and wraps the
 * captured output, exposing it to the layout as $content.
 *
 * Templates receive variables as locals. Output is escaped with e(); CMS body
 * HTML is the only thing printed raw, and it is sanitised on save.
 */

namespace Mktr\Core;

class View
{
    /** @var string */
    private static $path = '';

    /** @var array<string,mixed> shared with every render */
    private static $shared = [];

    public static function setPath(string $path): void
    {
        self::$path = rtrim($path, '/');
    }

    /**
     * @param mixed $value
     */
    public static function share(string $key, $value): void
    {
        self::$shared[$key] = $value;
    }

    public static function render(string $template, array $data = []): string
    {
        $result  = self::capture(self::resolve($template), array_merge(self::$shared, $data));
        $content = $result['output'];
        $layout  = $result['layout'];

        /*
         * Variables a template declares for its layout — $heading, $title,
         * $scripts — are collected during capture and handed upward, since the
         * layout is rendered after the template and would not otherwise see
         * them.
         */
        $data = array_merge($data, $result['exports']);

        // Layouts may themselves extend another layout.
        $guard = 0;
        while ($layout !== null && $guard < 5) {
            $result  = self::capture(
                self::resolve($layout),
                array_merge(self::$shared, $data, ['content' => $content])
            );
            $content = $result['output'];
            $layout  = $result['layout'];
            $data    = array_merge($data, $result['exports']);
            $guard++;
        }

        return $content;
    }

    /**
     * Render a nested template and return its output. Layout declarations are
     * ignored for partials.
     */
    public static function partial(string $template, array $data = []): string
    {
        $result = self::capture(self::resolve($template), array_merge(self::$shared, $data));

        return $result['output'];
    }

    public static function exists(string $template): bool
    {
        return is_file(self::$path . '/' . str_replace('.', '/', $template) . '.php');
    }

    private static function resolve(string $template): string
    {
        $file = self::$path . '/' . str_replace('.', '/', $template) . '.php';

        if (!is_file($file)) {
            throw new \RuntimeException('View not found: ' . $template);
        }

        return $file;
    }

    /**
     * @return array{output:string,layout:?string,exports:array<string,mixed>}
     */
    private static function capture(string $__file, array $__data): array
    {
        extract($__data, EXTR_SKIP);

        // Only a layout declared by THIS template should be honoured, not one
        // inherited through $__data from a child template.
        $layout = null;

        ob_start();

        try {
            include $__file;
        } catch (\Throwable $e) {
            ob_end_clean();
            throw $e;
        }

        $__output = (string) ob_get_clean();

        // Anything the template defined or changed, minus this method's own
        // bookkeeping, travels up to the layout.
        $__exports = get_defined_vars();
        unset(
            $__exports['__file'],
            $__exports['__data'],
            $__exports['__output'],
            $__exports['layout']
        );

        foreach (array_keys($__data) as $__key) {
            if (array_key_exists($__key, $__exports) && $__exports[$__key] === $__data[$__key]) {
                unset($__exports[$__key]);
            }
        }

        return [
            'output'  => $__output,
            'layout'  => is_string($layout) && $layout !== '' ? $layout : null,
            'exports' => $__exports,
        ];
    }
}
