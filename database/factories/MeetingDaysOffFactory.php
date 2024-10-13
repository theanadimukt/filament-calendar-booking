<?php

namespace Theanadimukt\CalendarBooking\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Theanadimukt\CalendarBooking\Models\MeetingDaysOff;

class MeetingDaysOffFactory extends Factory
{
    protected $model = MeetingDaysOff::class;

    public function definition(): array
    {
        return [
            'start_at' => $this->faker->dateTimeBetween('-1 day', 'now'),
            'end_at' => $this->faker->dateTimeBetween('+1 day', '+2 day'),
        ];
    }
}
