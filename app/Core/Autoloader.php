<?php
/**
 * PSR-4 style autoloader.
 *
 * Composer is not available on the target host, so class loading is registered
 * by hand. Namespace prefixes map to directories; `Mktr\Core\Router` resolves to
 * app/Core/Router.php.
 */

namespace Mktr\Core;

class Autoloader
{
    /** @var array<string,string> namespace prefix => base directory */
    private $prefixes = [];

    public function register(): void
    {
        spl_autoload_register([$this, 'load']);
    }

    public function addNamespace(string $prefix, string $baseDir): void
    {
        $prefix = trim($prefix, '\\') . '\\';
        $this->prefixes[$prefix] = rtrim($baseDir, '/') . '/';
    }

    public function load(string $class): bool
    {
        foreach ($this->prefixes as $prefix => $baseDir) {
            if (strpos($class, $prefix) !== 0) {
                continue;
            }

            $relative = substr($class, strlen($prefix));
            $file     = $baseDir . str_replace('\\', '/', $relative) . '.php';

            if (is_file($file)) {
                require $file;
                return true;
            }
        }

        return false;
    }
}
