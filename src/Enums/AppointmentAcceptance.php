<?php

namespace Theanadimukt\FilamentAppointment\Enums;

enum AppointmentAcceptance: int
{
    use EnumHelper;

    case Automatic = 1;
    case Manual = 2;
}
