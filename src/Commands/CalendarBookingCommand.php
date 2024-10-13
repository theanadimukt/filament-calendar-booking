<?php

namespace Theanadimukt\CalendarBooking\Commands;

use Illuminate\Console\Command;

class CalendarBookingCommand extends Command
{
    public $signature = 'filament-calendar-booking';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
