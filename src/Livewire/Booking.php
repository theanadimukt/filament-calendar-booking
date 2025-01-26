<?php

namespace Theanadimukt\CalendarBooking\Livewire;

use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Livewire\Component;
use Theanadimukt\CalendarBooking\Models\Meeting;

class Booking extends Component
{
    public Meeting $meeting;

    public Carbon $date;

    public array $dateNumbers;

    public array $days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];

    public array $colStartClasses = [
        '',
        'col-start-2',
        'col-start-3',
        'col-start-4',
        'col-start-5',
        'col-start-6',
        'col-start-7',
    ];

    public string $currentMonth;

    public string $currentYear;

    public function mount(): void
    {
        $this->date = Carbon::now();
        $this->updateCalendar();
    }

    public function render(): View
    {

        return view('filament-calendar-booking::livewire.booking');
    }

    public function nextMonth(): void
    {
        $this->date = Carbon::createFromFormat('F Y', "$this->currentMonth $this->currentYear")->addMonth();
        $this->currentMonth = $this->date->format('F');
        $this->currentYear = $this->date->format('Y');
        $this->generateDays();
    }

    public function prevMonth(): void
    {
        $this->date = Carbon::createFromFormat('F Y', "$this->currentMonth $this->currentYear")->subMonth();
        $this->currentMonth = $this->date->format('F');
        $this->currentYear = $this->date->format('Y');
        $this->generateDays();
    }

    public function updateCalendar(): void
    {
        $this->currentMonth = $this->date->format('F');
        $this->currentYear = $this->date->format('Y');
        $this->generateDays();
    }

    private function generateDays(): void
    {
        $daysInMonth = $this->date->daysInMonth();
        $this->dateNumbers = range(1, $daysInMonth);
    }
}
