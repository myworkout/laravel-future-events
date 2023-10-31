<?php
declare(strict_types=1);

namespace Myworkout\LaravelFutureEvents\Services;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Myworkout\LaravelFutureEvents\Models\TimeWindow;

class TimeWindowService
{
    public function advance(string $identifier, CarbonImmutable $end, callable $callback): mixed
    {
        $lock = Cache::lock("time-window-advance_{$identifier}", 60);
        return $lock->block(0, function () use ($identifier, $end, $callback) {
            $lastTimeWindow = TimeWindow::query()
                ->whereIdentifier($identifier)
                ->orderByDesc('end')
                ->first();
            $previousStart = $lastTimeWindow?->start?->toImmutable() ?? CarbonImmutable::now();

            if ($lastTimeWindow !== null && $end->isBefore($lastTimeWindow->end)) {
                throw new \Exception('Cannot advance time window backwards');
            }

            $this->persistNewTimeWindow($identifier, CarbonImmutable::now(), $end);
            return $callback($previousStart, $end);
        });
    }

    private function persistNewTimeWindow(string $identifier, CarbonImmutable $start, CarbonImmutable $end): void
    {
        $newTimeWindow = new TimeWindow([
            'identifier' => $identifier,
            'start' => $start,
            'end' => $end,
        ]);
        $newTimeWindow->save();
    }
}
