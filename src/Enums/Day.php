<?php

namespace Theanadimukt\CalendarBooking\Enums;

use Illuminate\Support\Str;

enum Day: string
{
    use EnumHelper;

    case SUNDAY = 'sunday';
    case MONDAY = 'monday';
    case TUESDAY = 'tuesday';
    case WEDNESDAY = 'wednesday';
    case THURSDAY = 'thursday';
    case FRIDAY = 'friday';
    case SATURDAY = 'saturday';

    public function label(): string
    {
        return Str::headline($this->value);
    }
}
