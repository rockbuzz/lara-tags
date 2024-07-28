<?php

namespace Rockbuzz\LaraTags\Tests;

use Rockbuzz\LaraTags\ServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testing']);

        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--path' => realpath(__DIR__ . '/../src/database/migrations'),
        ]);

        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--path' => realpath(__DIR__ . '/migrations'),
        ]);
    }


    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testing');
    }


    protected function getPackageProviders($app): array
    {
        return [ServiceProvider::class];
    }
}