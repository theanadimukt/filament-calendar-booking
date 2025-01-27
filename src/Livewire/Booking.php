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

    public array $availableSlots = []; // Stores the generated time slots

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
        // Generate the first & last day of the current month
        $daysInMonth = $this->date->daysInMonth();

        // Start and end of the current month
        $monthStart = $this->date->copy()->startOfMonth();
        $monthEnd = $this->date->copy()->endOfMonth();

        // Meeting date range
        $meetingStart = $this->meeting->start_at->startOfDay();
        $meetingEnd = $this->meeting->end_at->endOfDay();

        // Determine the valid date range within the current month
        $validStart = $monthStart->greaterThanOrEqualTo($meetingStart) ? $monthStart : $meetingStart;
        $validEnd = $monthEnd->lessThanOrEqualTo($meetingEnd) ? $monthEnd : $meetingEnd;

        // Ensure there is an overlap between the meeting date range and the current month
        if ($validStart->lessThanOrEqualTo($validEnd)) {
            $allDates = collect(range($validStart->day, $validEnd->day))->map(
                fn ($day) => $validStart->copy()->day($day)
            );

            // Exclude dates within meeting_days_off
            $excludedDates = $this->meeting->daysOff()
                ->select('start_at', 'end_at')
                ->get()
                ->flatMap(function ($dayOff) {
                    return collect(Carbon::parse($dayOff->start_at)->daysUntil($dayOff->end_at));
                });

            $this->dateNumbers = $allDates
                ->reject(fn ($date) => $excludedDates->contains(fn ($excluded) => $date->isSameDay($excluded)))
                ->map(fn ($date) => $date->day)
                ->toArray();
        } else {
            $this->dateNumbers = []; // No valid dates in the current month
        }
    }

    public function selectDate(int $dateNumber): void
    {
        if (! in_array($dateNumber, $this->dateNumbers)) {
            return; // Ignore invalid date selection
        }

        // Get the selected date
        $selectedDate = $this->date->copy()->day($dateNumber);

        // Check if the selected date falls within an unavailable range
        $isDayOff = $this->meeting->daysOff()
            ->whereDate('start_at', '<=', $selectedDate)
            ->whereDate('end_at', '>=', $selectedDate)
            ->exists();

        if ($isDayOff) {
            return; // Ignore unavailable dates
        }

        $this->date = $selectedDate;

        // Fetch and set the available slots for the selected date
        $this->generateSlotsForDate();
    }

    private function generateSlotsForDate(): void
    {
        $dayOfWeek = $this->date->format('D'); // Example: 'Mon', 'Tue', etc.
        $this->availableSlots = []; // Reset slots

        // Check if the date is entirely unavailable
        $isDayOff = $this->meeting->daysOff()
            ->whereDate('start_at', '<=', $this->date)
            ->whereDate('end_at', '>=', $this->date)
            ->exists();

        if ($isDayOff) {
            return; // No slots if the date is unavailable
        }

        // Fetch available hours for the selected day
        $availableHours = $this->meeting->availableHours()
            ->where('day', strtolower($dayOfWeek))
            ->get();

        foreach ($availableHours as $hours) {
            $startTime = Carbon::createFromTimeString($hours->from);
            $endTime = Carbon::createFromTimeString($hours->to);
            $slotDuration = $this->meeting->slots_period_minutes;

            // Generate slots within the start and end time
            while ($startTime->lt($endTime)) {
                $slotRangeStart = $this->date->copy()->setTimeFrom($startTime);
                $slotRangeEnd = $this->date->copy()->setTimeFrom($startTime)->addMinutes($slotDuration);

                // Ensure the slot does not overlap with unavailable ranges
                $isSlotUnavailable = $this->meeting->daysOff()
                    ->whereDate('start_at', '<=', $slotRangeStart)
                    ->whereDate('end_at', '>=', $slotRangeEnd)
                    ->exists();

                if (!$isSlotUnavailable) {
                    $this->availableSlots[] = $startTime->format('H:i'); // Format as "HH:mm"
                }

                $startTime->addMinutes($slotDuration);
            }
        }
    }

    public function bookSlot(string $slot): void
    {
        // Implement appointment booking logic here
        // Example: Emit an event or redirect to the next step
        session()->flash('success', "You have selected the time slot: {$slot}");
    }
}
