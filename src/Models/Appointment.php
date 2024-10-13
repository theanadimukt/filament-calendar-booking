<?php

namespace Theanadimukt\CalendarBooking\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mews\Purifier\Casts\CleanHtml;
use Theanadimukt\CalendarBooking\Database\Factories\AppointmentFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'guest_note' => CleanHtml::class,
        'appointment_at' => 'date',
        'appointment_time' => 'time',
    ];

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }

    protected static function newFactory(): Factory
    {
        return AppointmentFactory::new();
    }
}
