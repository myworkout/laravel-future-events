<?php

namespace Myworkout\LaravelFutureEvents\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Myworkout\LaravelFutureEvents\LaravelFutureEvents
 */
class LaravelFutureEvents extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Myworkout\LaravelFutureEvents\LaravelFutureEvents::class;
    }
}
