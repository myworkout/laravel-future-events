<?php

namespace Myworkout\LaravelFutureEvents\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Myworkout\LaravelFutureEvents\Models\TimeWindow;

class TimeWindowFactory extends Factory
{
    protected $model = TimeWindow::class;

    public function definition(): array
    {
        return [
            'identifier' => $this->faker->uuid(),
            'start' => $this->faker->dateTimeBetween('-1 day', 'now'),
            'end' => $this->faker->dateTimeBetween('now', '+1 day'),
        ];
    }
}
