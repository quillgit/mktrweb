<?php
/**
 * PHP 7.4 compatibility check.
 *
 * The production host runs PHP 7.4, but no 7.4 binary is available in the
 * development environment (the ondrej PPA is unreachable from here), and
 * linting on 8.x cannot catch code that is *too new* for 7.4. This scans for
 * syntax and functions introduced in PHP 8.0+ using the tokenizer, so string
 * and comment contents are not mistaken for code.
 *
 *   php database/check-php74.php
 *
 * Exit code 0 = clean, 1 = findings.
 */

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

$root  = dirname(__DIR__);
$paths = ['/app', '/config', '/database', '/v2'];

/** Functions added in PHP 8.0+. */
$newFunctions = [
    'str_contains'    => '8.0',
    'str_starts_with' => '8.0',
    'str_ends_with'   => '8.0',
    'array_is_list'   => '8.1',
    'enum_exists'     => '8.1',
    'json_validate'   => '8.3',
];

$findings = [];
$scanned  = 0;

$files = [];
foreach ($paths as $path) {
    $directory = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($root . $path, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($directory as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $files[] = $file->getPathname();
        }
    }
}

sort($files);

foreach ($files as $file) {
    $scanned++;
    $code   = (string) file_get_contents($file);
    $tokens = token_get_all($code);
    $short  = str_replace($root . '/', '', $file);

    $depth        = 0;
    $inParams     = false;
    $paramDepth   = 0;
    $lastNonSpace = null;

    foreach ($tokens as $index => $token) {
        if (is_array($token)) {
            list($id, $text, $line) = $token;

            /*
             * On PHP 8 the tokenizer emits dedicated T_MATCH / T_ENUM tokens,
             * so the T_STRING checks below never fire there. Both paths are
             * kept so this script also works when run on PHP 7.
             */
            if (defined('T_MATCH') && $id === T_MATCH) {
                /*
                 * `match` is only an expression when it is not being used as a
                 * name. `function match(…)`, `$obj->match(…)` and `Cls::match()`
                 * are all legal in 7.4 — semi-reserved words have been allowed
                 * as method names since PHP 7.0.
                 */
                $isName = is_array($lastNonSpace)
                    && in_array($lastNonSpace[0], [T_FUNCTION, T_OBJECT_OPERATOR, T_DOUBLE_COLON], true);

                if (!$isName) {
                    $findings[] = [$short, $line, 'match expression (PHP 8.0)'];
                }
            }

            if (defined('T_ENUM') && $id === T_ENUM) {
                $isName = is_array($lastNonSpace)
                    && in_array($lastNonSpace[0], [T_FUNCTION, T_OBJECT_OPERATOR, T_DOUBLE_COLON], true);

                if (!$isName) {
                    $findings[] = [$short, $line, 'enum declaration (PHP 8.1)'];
                }
            }

            // ---- match expression (8.0) — distinguish from a method named match
            if ($id === T_STRING && strtolower($text) === 'match') {
                $next = $index;
                do { $next++; } while (isset($tokens[$next]) && is_array($tokens[$next]) && $tokens[$next][0] === T_WHITESPACE);

                $prevIsArrow = is_array($lastNonSpace)
                    && in_array($lastNonSpace[0], [T_OBJECT_OPERATOR, T_DOUBLE_COLON, T_FUNCTION], true);

                if (!$prevIsArrow && isset($tokens[$next]) && $tokens[$next] === '(') {
                    $findings[] = [$short, $line, 'match expression (PHP 8.0)'];
                }
            }

            // ---- enum (8.1)
            if ($id === T_STRING && strtolower($text) === 'enum') {
                $next = $index;
                do { $next++; } while (isset($tokens[$next]) && is_array($tokens[$next]) && $tokens[$next][0] === T_WHITESPACE);

                if (isset($tokens[$next]) && is_array($tokens[$next]) && $tokens[$next][0] === T_STRING) {
                    $findings[] = [$short, $line, 'enum declaration (PHP 8.1)'];
                }
            }

            // ---- readonly (8.1)
            if ($id === T_STRING && strtolower($text) === 'readonly') {
                $findings[] = [$short, $line, 'readonly modifier (PHP 8.1)'];
            }

            // ---- functions newer than 7.4
            if ($id === T_STRING && isset($newFunctions[strtolower($text)])) {
                $prevIsMember = is_array($lastNonSpace)
                    && in_array($lastNonSpace[0], [T_OBJECT_OPERATOR, T_DOUBLE_COLON, T_FUNCTION], true);

                if (!$prevIsMember) {
                    $findings[] = [$short, $line, strtolower($text) . '() (PHP ' . $newFunctions[strtolower($text)] . ')'];
                }
            }

            // ---- nullsafe operator (8.0)
            if (defined('T_NULLSAFE_OBJECT_OPERATOR') && $id === T_NULLSAFE_OBJECT_OPERATOR) {
                $findings[] = [$short, $line, 'nullsafe operator ?-> (PHP 8.0)'];
            }

            // ---- attributes (8.0)
            if (defined('T_ATTRIBUTE') && $id === T_ATTRIBUTE) {
                $findings[] = [$short, $line, 'attribute #[…] (PHP 8.0)'];
            }

            // ---- constructor property promotion (8.0)
            if ($inParams && in_array($id, [T_PUBLIC, T_PRIVATE, T_PROTECTED], true)) {
                $findings[] = [$short, $line, 'constructor property promotion (PHP 8.0)'];
            }

            if ($id !== T_WHITESPACE && $id !== T_COMMENT && $id !== T_DOC_COMMENT) {
                $lastNonSpace = $token;
            }

            continue;
        }

        // ---- track parameter lists so promotion can be detected
        if ($token === '(') {
            $depth++;
            if (!$inParams && is_array($lastNonSpace) && $lastNonSpace[0] === T_STRING) {
                // opening paren directly after a function name
                $inParams   = true;
                $paramDepth = $depth;
            }
        } elseif ($token === ')') {
            if ($inParams && $depth === $paramDepth) {
                $inParams = false;
            }
            $depth--;
        }

        $lastNonSpace = $token;
    }

    // ---- union types in signatures (8.0); `?Type` and `A|B` differ textually
    if (preg_match_all('/function\s+\w+\s*\([^)]*\)\s*:\s*[A-Za-z_\\\\]+\s*\|/', $code, $m, PREG_OFFSET_CAPTURE)) {
        foreach ($m[0] as $match) {
            $line = substr_count(substr($code, 0, $match[1]), "\n") + 1;
            $findings[] = [$short, $line, 'union return type (PHP 8.0)'];
        }
    }
}

echo "Scanned {$scanned} files for PHP 8.0+ constructs.\n";

if ($findings === []) {
    echo "OK — nothing found that PHP 7.4 cannot parse.\n";
    exit(0);
}

foreach ($findings as $finding) {
    printf("  %s:%d  %s\n", $finding[0], $finding[1], $finding[2]);
}

printf("\n%d finding(s).\n", count($findings));
exit(1);
