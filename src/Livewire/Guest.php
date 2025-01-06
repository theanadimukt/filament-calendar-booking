<?php

namespace Theanadimukt\CalendarBooking\Livewire;

use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Livewire\Component;

class Guest extends Component
{
    public int $currentMonth;

    public int $currentYear;

    public array $events = [];

    public function mount(): void
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
    }

    public function render(): View
    {

        return view('filament-calendar-booking::livewire.guest');
    }

    public function nextMonth(): void
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function prevMonth(): void
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }
}
