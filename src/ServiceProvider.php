<?php

namespace Rockbuzz\LaraTags;

use Illuminate\Support\ServiceProvider as SupportServiceProvider;

class ServiceProvider extends SupportServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->publishes([
            __DIR__ . '/database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/config/tags.php' => config_path('tags.php')
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/tags.php', 'tags');
    }
}
