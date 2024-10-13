<?php

namespace Theanadimukt\CalendarBooking\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Casts\CleanHtml;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Theanadimukt\CalendarBooking\Database\Factories\MeetingFactory;

class Meeting extends Model
{
    use HasFactory,
        HasSlug;

    protected $guarded = ['id'];

    protected $casts = [
        'title' => 'string',
        'description' => CleanHtml::class,
        'start_at' => 'date',
        'end_at' => 'date',
        'active' => 'boolean',
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

    protected static function newFactory(): Factory
    {
        return MeetingFactory::new();
    }
}