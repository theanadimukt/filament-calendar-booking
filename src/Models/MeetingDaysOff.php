<?php

namespace Theanadimukt\CalendarBooking\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Theanadimukt\CalendarBooking\Database\Factories\MeetingDaysOffFactory;

class MeetingDaysOff extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'start_at' => 'date',
        'end_at' => 'date',
    ];

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }

    protected static function newFactory(): Factory
    {
        return MeetingDaysOffFactory::new();
    }
}