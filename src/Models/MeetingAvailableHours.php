<?php

namespace Theanadimukt\CalendarBooking\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Theanadimukt\CalendarBooking\Database\Factories\MeetingAvailableHoursFactory;

class MeetingAvailableHours extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }

    protected static function newFactory(): Factory
    {
        return MeetingAvailableHoursFactory::new();
    }

    public function scopeForDay($query, $day)
    {
        return $query->where('day', $day);
    }
}
