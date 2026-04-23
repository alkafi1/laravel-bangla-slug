<?php

namespace Alkafi1\BanglaSlug\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Alkafi1\BanglaSlug\BanglaSlugServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            BanglaSlugServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
