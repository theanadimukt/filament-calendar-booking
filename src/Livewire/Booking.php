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

    public array $dateNumbers = [];

    public array $days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];

    public string $currentMonth;

    public string $currentYear;

    /*public array $colStartClasses = [
        '',
        'col-start-2',
        'col-start-3',
        'col-start-4',
        'col-start-5',
        'col-start-6',
        'col-start-7',
    ];*/

    public int $selectedDate = 0; // Used to highlight the selected date

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
        $this->date = $this->date->addMonth(); // Move to the next month
        $this->updateCalendar();

    }

    public function prevMonth(): void
    {
        $this->date = $this->date->subMonth(); // Move to the previous month
        $this->updateCalendar();

    }

    public function updateCalendar(): void
    {
        $this->currentMonth = $this->date->format('F');
        $this->currentYear = $this->date->format('Y');
        $this->generateDays();
    }

    private function generateDays(): void
    {
        // Get the first and last days of the current month
        $firstDayOfMonth = $this->date->copy()->startOfMonth();
        $lastDayOfMonth = $this->date->copy()->endOfMonth();

        // Meeting date constraints
        $meetingStart = $this->meeting->start_at->copy()->startOfDay();
        $meetingEnd = $this->meeting->end_at->copy()->endOfDay();

        // Get meeting days off
        $daysOff = $this->meeting->daysOff()
            ->select('start_at', 'end_at')
            ->get()
            ->map(function ($dayOff) {
                return [
                    'start_at' => Carbon::create($dayOff->start_at),
                    'end_at' => Carbon::create($dayOff->end_at),
                ];
            });


        // Placeholders for empty slots before the first day
        $startingDayOfWeek = $firstDayOfMonth->dayOfWeek; // 0 = Sunday, 6 = Saturday
        $placeholders = array_fill(0, $startingDayOfWeek, null);

        // Generate valid dates within the calendar month and within the meeting's constraints
        $validDates = [];
        for ($day = 1; $day <= $lastDayOfMonth->day; $day++) {
            $currentDate = $firstDayOfMonth->copy()->day($day);

            // Check if the date is within a day-off range
            $isDayOff = $daysOff->contains(function ($dayOff) use ($currentDate) {
                return $currentDate->between($dayOff['start_at'], $dayOff['end_at']);
            });

            $validDates[] = [
                'day' => $day,
                'enabled' => $currentDate->between($meetingStart, $meetingEnd) && ! $isDayOff, // Validate within meeting bounds and excludes day-offs
            ];
        }


        // Combine placeholders with the days
        $this->dateNumbers = array_merge($placeholders, $validDates);

    }

    public function selectDate(int $dateNumber): void
    {
        // Ensure the selected date is within the valid date range
        $selectedDay = collect($this->dateNumbers)->filter(function ($date) use ($dateNumber) {
            return is_array($date) && $date['day'] === $dateNumber && $date['enabled'];
        })->first();

        // If the day is not enabled, ignore the selection
        if (! $selectedDay) {
            return;
        }

        $this->selectedDate = $dateNumber; // Highlight the selected date
        $this->date = $this->date->copy()->day($dateNumber); // Update the selected date

        // Optionally, generate time slots or additional logic can be handled here
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

                // Ensure the slot does not fall within an unavailable (day-off) range
                $isSlotUnavailable = $this->meeting->daysOff()
                    ->whereDate('start_at', '<=', $slotRangeStart)
                    ->whereDate('end_at', '>=', $slotRangeEnd)
                    ->exists();

                if (! $isSlotUnavailable) {
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
