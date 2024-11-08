<?php

namespace Theanadimukt\CalendarBooking\Http\Controllers;

use Illuminate\View\View;
use Theanadimukt\CalendarBooking\Models\Meeting;

class MeetingController extends Controller
{
    public function show(string $slug): View
    {
        $meeting = Meeting::query()->where('slug', $slug)->first();

        return view('filament-calendar-booking::meeting.show', compact('meeting'));
    }
}
