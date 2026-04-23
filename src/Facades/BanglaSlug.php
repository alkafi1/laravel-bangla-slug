<?php

namespace Alkafi1\BanglaSlug\Facades;

use Illuminate\Support\Facades\Facade;

class BanglaSlug extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bangla-slug';
    }
}
