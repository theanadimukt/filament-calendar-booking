<?php

namespace Theanadimukt\CalendarBooking\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Theanadimukt\CalendarBooking\CalendarBooking
 */
class CalendarBooking extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Theanadimukt\CalendarBooking\CalendarBooking::class;
    }
}
