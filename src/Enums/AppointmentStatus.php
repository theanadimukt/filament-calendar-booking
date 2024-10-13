<?php

namespace Theanadimukt\CalendarBooking\Enums;

enum AppointmentStatus: int
{
    use EnumHelper;

    case Pending = 0;
    case Submitted = 1;
    case Approved = 2;
    case Declined = 3;
    case OnTime = 4;
    case Completed = 5;
    case Expired = 6;
}
