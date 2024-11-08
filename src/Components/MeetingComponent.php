<?php

namespace Theanadimukt\CalendarBooking\Components;

use Illuminate\View\Component;

class MeetingComponent extends Component
{
    public function render()
    {
        return view('filament-calendar-booking::meeting');
    }
}