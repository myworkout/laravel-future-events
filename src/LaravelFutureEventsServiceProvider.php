<?php

namespace Myworkout\LaravelFutureEvents;

use Myworkout\LaravelFutureEvents\Commands\RunLaravelFutureEventsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelFutureEventsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-future-events')
            ->hasConfigFile()
            ->hasMigration('create_laravel-future-events_table')
            ->hasCommand(RunLaravelFutureEventsCommand::class);
    }
}
