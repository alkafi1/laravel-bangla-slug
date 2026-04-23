<?php

namespace Alkafi1\BanglaSlug;

class BanglaSlug
{
    /**
     * Generate a slug from the given Bengali string.
     *
     * @param  string  $title
     * @param  array|string|null  $options
     * @return string
     */
    public function make(string $title, array|string|null $options = null): string
    {
        // For backwards compatibility with string separator
        if (is_string($options)) {
            $options = ['separator' => $options];
        }

        $options = $options ?? [];

        // Load configurations with fallbacks
        $separator = $options['separator'] ?? config('bangla-slug.separator', '-');
        $keepEnglish = $options['keep_english'] ?? config('bangla-slug.keep_english', true);
        $maxLength = $options['max_length'] ?? config('bangla-slug.max_length', null);
        $replacements = $options['replacements'] ?? config('bangla-slug.replacements', []);

        // Apply custom replacements first
        if (!empty($replacements)) {
            $title = str_replace(array_keys($replacements), array_values($replacements), $title);
        }

        // Convert the string to lowercase
        $title = mb_strtolower($title, 'UTF-8');

        // Determine the allowed character range based on options
        // \x{0980}-\x{09FF} is the Unicode block for Bengali
        $allowedPattern = '\x{0980}-\x{09FF}\s' . preg_quote($separator);
        
        if ($keepEnglish) {
            $allowedPattern .= 'A-Za-z0-9';
        } else {
            $allowedPattern .= '0-9'; // Always keep numbers
        }

        // Remove unwanted characters
        $title = preg_replace('/[^' . $allowedPattern . ']/u', '', $title);

        // Replace multiple spaces or separators with a single separator
        $title = preg_replace('/[\s' . preg_quote($separator) . ']+/u', $separator, $title);

        // Trim separator from the beginning and end
        $title = trim($title, $separator);

        // Truncate to max length if defined
        if ($maxLength && mb_strlen($title, 'UTF-8') > $maxLength) {
            $title = mb_substr($title, 0, $maxLength, 'UTF-8');
            // Trim again in case we cut in the middle of a separator
            $title = rtrim($title, $separator);
        }

        return $title;
    }
}
