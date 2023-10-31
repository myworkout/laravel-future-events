<?php

namespace Myworkout\LaravelFutureEvents\Commands;

use Illuminate\Console\Command;

class RunLaravelFutureEventsCommand extends Command
{
    public $signature = 'laravel-future-events:run';

    public $description = 'Check all classes ';

    public function __construct(private readonly TimeWindowService $timeWindowService)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
