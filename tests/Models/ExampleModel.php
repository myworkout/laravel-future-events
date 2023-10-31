<?php

declare(strict_types=1);

namespace Myworkout\LaravelFutureEvents\Tests\Models;

use Carbon\CarbonImmutable;

class ExampleModel implements HasAutomaticStateTransitions
{
    /**
     * @return Collection<int, FutureEvent>
     */
    public static function getFutureEventsInTimeWindow(
        CarbonImmutable $start,
        CarbonImmutable $end
    ): Collection {
        return \Myworkout\LaravelFutureEvents\Tests\ExampleModel::query()
            ->where(fn (Builder $query) => $query->where('start_at', '>=', $start)
                ->where('start_at', '<', $end)
                ->where('state', ExampleModelState::scheduled))
            ->orWhere(fn (Builder $query) => $query->where('end_at', '>=', $start)
                ->where('end_at', '<', $end)
                ->where('state', ExampleModelState::started))
            ->get()
            ->map(fn (ExampleModel $contestRound) => match ($contestRound->state) {
                ExampleModelState::scheduled => new FutureEvent(
                    $contestRound,
                    $contestRound->start_at->toImmutable(),
                ),
                ContestRoundState::started => new Transition(
                    $contestRound,
                    $contestRound->end_at->toImmutable(),
                ),
                default => throw new \Exception('Invalid state: '.$contestRound->state->value)
            });
    }

    public static function calculateState(
        CarbonImmutable $startAt,
        CarbonImmutable $endAt,
        CarbonImmutable $now
    ): ExampleModelState {
        if ($now->isBefore($startAt)) {
            return ExampleModelState::scheduled;
        }

        if ($now->isBefore($endAt)) {
            return ExampleModelState::started;
        }

        return ExampleModelState::ended;
    }

    public function performedFutureEvents(CarbonImmutable $atTime): void
    {
        $desiredState = static::calculateState($this->start_at->toImmutable(), $this->end_at->toImmutable(), $atTime);

        if ($desiredState !== $this->state) {
            // $this->checkIfStateTransitionIsValid($this->state, $desiredState);
            $this->state = $desiredState;
            $this->save();
        }
    }

    public function performTransitionsForTime(CarbonImmutable $time): void
    {
        $desiredState = static::calculateState($this->start_at->toImmutable(), $this->end_at->toImmutable(), $time);

        if ($desiredState !== $this->state) {
            $this->checkIfStateTransitionIsValid($this->state, $desiredState);
            $this->state = $desiredState;
            $this->save();
        }
    }
}
