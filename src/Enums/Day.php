<?php

namespace Theanadimukt\FilamentAppointment\Enums;

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
}
