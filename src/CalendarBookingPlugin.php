<?php

namespace Theanadimukt\CalendarBooking;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Theanadimukt\CalendarBooking\Resources\MeetingResource;

class CalendarBookingPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-calendar-booking';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            MeetingResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
