<?php

declare(strict_types=1);

namespace Myworkout\LaravelFutureEvents\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

/**
 * App\Db\TimeWindow
 *
 * @property int $id
 * @property string $identifier
 * @property \Illuminate\Support\Carbon $start
 * @property \Illuminate\Support\Carbon $end
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static Builder|TimeWindow newModelQuery()
 * @method static Builder|TimeWindow newQuery()
 * @method static Builder|TimeWindow query()
 * @method static Builder|TimeWindow whereCreatedAt($value)
 * @method static Builder|TimeWindow whereEnd($value)
 * @method static Builder|TimeWindow whereId($value)
 * @method static Builder|TimeWindow whereIdentifier($value)
 * @method static Builder|TimeWindow whereStart($value)
 * @method static Builder|TimeWindow whereUpdatedAt($value)
 * @method static \Database\Factories\Db\TimeWindowFactory factory(...$parameters)
 *
 * @mixin \Eloquent
 */
class TimeWindow extends Model
{
    use HasFactory, Prunable;

    protected $table = 'time_windows';

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    protected $guarded = [];

    public function prunable(): Builder
    {
        return static::query()->where('created_at', '<=', Carbon::now()->subDays(30));
    }
}
