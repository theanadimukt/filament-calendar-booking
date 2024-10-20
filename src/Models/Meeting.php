<?php

namespace Theanadimukt\CalendarBooking\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mews\Purifier\Casts\CleanHtml;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Theanadimukt\CalendarBooking\Database\Factories\MeetingFactory;

/**
 * @property Collection<MeetingAvailableHours> availableHours
 */
class Meeting extends Model
{
    use HasFactory;
    use HasSlug;

    protected $guarded = ['id'];

    protected $casts = [
        'title' => 'string',
        'description' => CleanHtml::class,
        'start_at' => 'date',
        'end_at' => 'date',
        'slots_period_minutes' => 'integer',
        'appointment_per_slot' => 'integer',
        'appointment_notice_days' => 'integer',
        'cancellation_notice_days' => 'integer',
        'appointment_acceptance_mode' => 'integer',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50)
            ->doNotGenerateSlugsOnUpdate();
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function availableHours(): HasMany
    {
        return $this->hasMany(MeetingAvailableHours::class);
    }

    public function daysOff(): HasMany
    {
        return $this->hasMany(MeetingDaysOff::class);
    }

    public function scopeWithinDateRange($query, $date)
    {
        return $query
            ->whereDate('start_at', '<=', $date)
            ->whereDate('end_at', '>=', $date);
    }

    protected static function newFactory(): Factory
    {
        return MeetingFactory::new();
    }
}
