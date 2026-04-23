<?php

use Alkafi1\BanglaSlug\Facades\BanglaSlug;

if (! function_exists('bangla_slug')) {
    /**
     * Generate a slug from the given Bengali string.
     *
     * @param  string  $title
     * @param  array|string|null  $options
     * @return string
     */
    function bangla_slug(string $title, array|string|null $options = null): string
    {
        return BanglaSlug::make($title, $options);
    }
}
