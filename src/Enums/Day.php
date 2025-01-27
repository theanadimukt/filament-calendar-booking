<?php

namespace Theanadimukt\CalendarBooking\Enums;

use Illuminate\Support\Str;

enum Day: string
{
    use EnumHelper;

    case SUNDAY = 'sun';
    case MONDAY = 'mon';
    case TUESDAY = 'tue';
    case WEDNESDAY = 'wed';
    case THURSDAY = 'thu';
    case FRIDAY = 'fri';
    case SATURDAY = 'sat';

    public function label(): string
    {
        return match ($this) {
            Day::SUNDAY => 'Sunday',
            Day::MONDAY => 'Monday',
            Day::TUESDAY => 'Tuesday',
            Day::WEDNESDAY => 'Wednesday',
            Day::THURSDAY => 'Thursday',
            Day::FRIDAY => 'Friday',
            Day::SATURDAY => 'Saturday',
            default => Str::headline($this->value),
        };
    }
}
