<?php

namespace Theanadimukt\CalendarBooking\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Theanadimukt\CalendarBooking\Enums\Day;
use Theanadimukt\CalendarBooking\Models\Meeting;

class MeetingAvailableHoursFactory extends Factory
{
    protected $model = Meeting::class;

    public function definition()
    {
        return [
            'meeting_id' => Meeting::factory(),
            'day' => Day::MONDAY->value,
            'from' => $this->faker->time(),
            'to' => $this->faker->time(),
        ];
    }
}
