<?php
/**
 * Allowlist HTML sanitiser for rich-text content.
 *
 * HTMLPurifier is not an option without Composer, so this walks the parsed DOM
 * and removes anything not explicitly permitted. Editor output is sanitised on
 * SAVE, so what is stored is already safe and templates can print it raw.
 *
 * Blocked by construction: <script>, <iframe>, <object>, event handlers
 * (onclick=…), javascript: and data: URLs, style attributes.
 */

namespace Mktr\Core;

use DOMDocument;
use DOMElement;
use DOMNode;

class Html
{
    /** @var array<string,string[]> tag => allowed attributes */
    private static $allowed = [
        'p'          => ['class'],
        'br'         => [],
        'strong'     => [],
        'b'          => [],
        'em'         => [],
        'i'          => [],
        'u'          => [],
        's'          => [],
        'sub'        => [],
        'sup'        => [],
        'h2'         => ['id'],
        'h3'         => ['id'],
        'h4'         => ['id'],
        'h5'         => ['id'],
        'h6'         => ['id'],
        'ul'         => [],
        'ol'         => ['start'],
        'li'         => [],
        'blockquote' => ['cite'],
        'a'          => ['href', 'title', 'target', 'rel'],
        'img'        => ['src', 'alt', 'title', 'width', 'height', 'loading'],
        'figure'     => ['class'],
        'figcaption' => [],
        'table'      => ['class'],
        'thead'      => [],
        'tbody'      => [],
        'tfoot'      => [],
        'tr'         => [],
        'th'         => ['colspan', 'rowspan', 'scope'],
        'td'         => ['colspan', 'rowspan'],
        'hr'         => [],
        'div'        => ['class'],
        'span'       => ['class'],
    ];

    public static function sanitize(string $html): string
    {
        $html = trim($html);

        if ($html === '') {
            return '';
        }

        $document = new DOMDocument('1.0', 'UTF-8');

        $previous = libxml_use_internal_errors(true);

        // Wrap so the fragment keeps its structure, and force UTF-8 handling.
        $document->loadHTML(
            '<?xml encoding="UTF-8"><div id="mktr-root">' . $html . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NONET
        );

        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $root = $document->getElementById('mktr-root');

        if ($root === null) {
            return '';
        }

        self::clean($root);

        $output = '';
        foreach ($root->childNodes as $child) {
            $output .= $document->saveHTML($child);
        }

        return trim($output);
    }

    private static function clean(DOMNode $node): void
    {
        // Iterate over a snapshot; the live NodeList shifts as nodes are removed.
        $children = [];
        foreach ($node->childNodes as $child) {
            $children[] = $child;
        }

        foreach ($children as $child) {
            if ($child->nodeType === XML_TEXT_NODE) {
                continue;
            }

            if ($child->nodeType === XML_COMMENT_NODE) {
                $node->removeChild($child);
                continue;
            }

            if (!$child instanceof DOMElement) {
                $node->removeChild($child);
                continue;
            }

            $tag = strtolower($child->nodeName);

            if (!isset(self::$allowed[$tag])) {
                // Keep the text of an unknown wrapper, drop the wrapper itself;
                // but discard script/style contents entirely.
                if (in_array($tag, ['script', 'style', 'iframe', 'object', 'embed', 'form'], true)) {
                    $node->removeChild($child);
                    continue;
                }

                self::clean($child);

                while ($child->firstChild !== null) {
                    $node->insertBefore($child->firstChild, $child);
                }

                $node->removeChild($child);
                continue;
            }

            self::cleanAttributes($child, self::$allowed[$tag]);
            self::clean($child);
        }
    }

    private static function cleanAttributes(DOMElement $element, array $allowed): void
    {
        $attributes = [];
        foreach ($element->attributes as $attribute) {
            $attributes[] = $attribute->nodeName;
        }

        foreach ($attributes as $name) {
            $lower = strtolower($name);

            if (!in_array($lower, $allowed, true)) {
                $element->removeAttribute($name);
                continue;
            }

            if ($lower === 'href' || $lower === 'src' || $lower === 'cite') {
                $value = trim($element->getAttribute($name));

                if (!self::safeUrl($value)) {
                    $element->removeAttribute($name);
                }
            }
        }

        // Anything opening a new tab must not be able to reach window.opener.
        if (strtolower($element->nodeName) === 'a' && $element->getAttribute('target') === '_blank') {
            $element->setAttribute('rel', 'noopener noreferrer');
        }

        if (strtolower($element->nodeName) === 'img' && !$element->hasAttribute('loading')) {
            $element->setAttribute('loading', 'lazy');
        }
    }

    private static function safeUrl(string $url): bool
    {
        if ($url === '') {
            return false;
        }

        // Strip control characters that can hide a scheme, e.g. "java\0script:".
        $normalised = strtolower(preg_replace('/[\s\x00-\x1F\x7F]/', '', $url));

        foreach (['javascript:', 'vbscript:', 'data:', 'file:'] as $scheme) {
            if (strpos($normalised, $scheme) === 0) {
                return false;
            }
        }

        return true;
    }

    /**
     * Plain-text excerpt from rich content.
     */
    public static function excerpt(string $html, int $words = 28): string
    {
        $text = trim(preg_replace('/\s+/u', ' ', strip_tags($html)));

        if ($text === '') {
            return '';
        }

        $parts = explode(' ', $text);

        if (count($parts) <= $words) {
            return $text;
        }

        return implode(' ', array_slice($parts, 0, $words)) . '…';
    }
}
