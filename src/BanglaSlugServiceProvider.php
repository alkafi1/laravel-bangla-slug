<?php

namespace Alkafi1\BanglaSlug;

use Illuminate\Support\ServiceProvider;

class BanglaSlugServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/bangla-slug.php', 'bangla-slug'
        );

        $this->app->singleton('bangla-slug', function ($app) {
            return new BanglaSlug();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/bangla-slug.php' => config_path('bangla-slug.php'),
        ], 'bangla-slug-config');
    }
}
