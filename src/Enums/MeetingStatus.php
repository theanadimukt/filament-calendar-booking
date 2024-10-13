<?php

namespace Theanadimukt\CalendarBooking\Enums;

enum MeetingStatus: int
{
    use EnumHelper;

    case Active = 1;
    case Inactive = 0;
}
