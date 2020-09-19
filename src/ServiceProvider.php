<?php

namespace Rockbuzz\LaraTags;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider as SupportServiceProvider;

class ServiceProvider extends SupportServiceProvider
{
    public function boot(Filesystem $filesystem)
    {
        $projectPath = database_path('migrations') . DIRECTORY_SEPARATOR;
        $localPath = __DIR__ . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'migrations' .
            DIRECTORY_SEPARATOR;

        if (! $this->hasMigrationInProject($projectPath, $filesystem)) {
            $this->loadMigrationsFrom($localPath . '2020_09_14_000000_create_tags_tables.php');

            $this->publishes([
                $localPath . '2020_09_14_000000_create_tags_tables.php' =>
                    $projectPath . now()->format('Y_m_d_his') . '_create_tags_tables.php'
            ], 'migrations');
        }

        $this->publishes([
            __DIR__ . '/config/tags.php' => config_path('tags.php')
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/tags.php', 'tags');
    }

    private function hasMigrationInProject(string $path, Filesystem $filesystem)
    {
        return count($filesystem->glob($path . '*_create_tags_tables.php')) > 0;
    }
}
