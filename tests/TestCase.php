<?php

namespace Myworkout\LaravelFutureEvents\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Myworkout\LaravelFutureEvents\LaravelFutureEventsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Myworkout\\LaravelFutureEvents\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelFutureEventsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-future-events_table.php.stub';
        $migration->up();
        */
    }
}
