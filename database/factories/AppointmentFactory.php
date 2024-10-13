<?php

namespace Theanadimukt\CalendarBooking\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Theanadimukt\CalendarBooking\Enums\AppointmentStatus;
use Theanadimukt\CalendarBooking\Models\Appointment;
use Theanadimukt\CalendarBooking\Models\Meeting;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        return [
            'meeting_id' => Meeting::factory(),
            'guest_name' => $this->faker->name(),
            'guest_email' => $this->faker->email(),
            'guest_note' => null,
            'appointment_per_slot' => 1,
            'appointment_at' => $this->faker->dateTimeBetween('+1 day'),
            'appointment_time' => $this->faker->time(),
            'status' => AppointmentStatus::Submitted->value,
        ];
    }
}
