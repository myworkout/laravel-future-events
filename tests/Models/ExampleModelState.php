<?php
declare(strict_types=1);

namespace Myworkout\LaravelFutureEvents\Tests\Models;

enum ExampleModelState: string {
    case scheduled = 'scheduled';
    case started = 'started';
    case ended = 'ended';
}
