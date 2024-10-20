<?php

namespace Theanadimukt\CalendarBooking\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Theanadimukt\CalendarBooking\Models\Meeting;

class MeetingFactory extends Factory
{
    protected $model = Meeting::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'start_at' => $this->faker->dateTimeBetween('-1 day', 'now'),
            'end_at' => $this->faker->dateTimeBetween('+1 day', '+2 day'),
            'slots_period_minutes' => 30,
            'appointment_per_slot' => 1,
            'appointment_notice_days' => 1,
            'cancellation_notice_days' => 1,
            'auto_acceptance' => true,
        ];
    }
}
