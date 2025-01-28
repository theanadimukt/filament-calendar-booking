<?php

namespace Theanadimukt\CalendarBooking\Livewire;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Livewire\Component;
use Theanadimukt\CalendarBooking\Enums\AppointmentStatus;
use Theanadimukt\CalendarBooking\Models\Appointment;
use Theanadimukt\CalendarBooking\Models\Meeting;

class Booking extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public Meeting $meeting;

    public Carbon $date;

    public array $dateNumbers = [];

    public array $days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];

    public string $currentMonth;

    public string $currentYear;

    public int $selectedDate = 0; // Highlights the selected date

    public array $availableSlots = []; // Stores generated time slots

    public ?string $selectedSlot = null;

    public function mount(): void
    {
        $this->form->fill();
        $this->date = Carbon::now();
        $this->updateCalendar();
    }

    public function render(): View
    {
        return view('filament-calendar-booking::livewire.booking');
    }

    // Navigation Methods
    public function nextMonth(): void
    {
        $this->date->addMonth();
        $this->updateCalendar();
    }

    public function prevMonth(): void
    {
        $this->date->subMonth();
        $this->updateCalendar();
    }

    // Calendar Update Methods
    private function updateCalendar(): void
    {
        $this->currentMonth = $this->date->format('F');
        $this->currentYear = $this->date->format('Y');
        $this->generateDays();
    }

    private function generateDays(): void
    {
        $firstDayOfMonth = $this->date->copy()->startOfMonth();
        $lastDayOfMonth = $this->date->copy()->endOfMonth();

        $meetingStart = $this->meeting->start_at->copy()->startOfDay();
        $meetingEnd = $this->meeting->end_at->copy()->endOfDay();

        $daysOff = $this->meeting->daysOff()->get()->map(fn ($dayOff) => [
            'start_at' => Carbon::create($dayOff->start_at),
            'end_at' => Carbon::create($dayOff->end_at),
        ]);

        $placeholders = array_fill(0, $firstDayOfMonth->dayOfWeek, null);

        $validDates = [];
        for ($day = 1; $day <= $lastDayOfMonth->day; $day++) {
            $currentDate = $firstDayOfMonth->copy()->day($day);

            $isDayOff = $daysOff->contains(fn ($dayOff) => $currentDate->between($dayOff['start_at'], $dayOff['end_at']));

            $validDates[] = [
                'day' => $day,
                'enabled' => $currentDate->between($meetingStart, $meetingEnd) && ! $isDayOff,
            ];
        }

        $this->dateNumbers = array_merge($placeholders, $validDates);
    }

    public function selectDate(int $dateNumber): void
    {
        $selectedDay = collect($this->dateNumbers)->firstWhere('day', $dateNumber);

        if (! $selectedDay['enabled'] ?? false) {
            return;
        }

        $this->selectedDate = $dateNumber;
        $this->date->day($dateNumber);
        $this->generateSlotsForDate();
    }

    private function generateSlotsForDate(): void
    {
        $dayOfWeek = strtolower($this->date->format('D'));
        $this->availableSlots = [];

        if ($this->isDayOff($this->date)) {
            return;
        }

        $availableHours = $this->meeting->availableHours()->where('day', $dayOfWeek)->get();
        $slotDuration = $this->meeting->slots_period_minutes;

        foreach ($availableHours as $hours) {
            $this->generateTimeSlots($hours->from, $hours->to, $slotDuration);
        }
    }

    private function generateTimeSlots(string $start, string $end, int $duration): void
    {
        $startTime = Carbon::createFromTimeString($start);
        $endTime = Carbon::createFromTimeString($end);

        while ($startTime->lt($endTime)) {
            $slotStart = $this->date->copy()->setTimeFrom($startTime);
            $slotEnd = $slotStart->copy()->addMinutes($duration);

            if (! $this->isSlotUnavailable($slotStart, $slotEnd)) {
                $this->availableSlots[] = $startTime->format('H:i');
            }

            $startTime->addMinutes($duration);
        }
    }

    private function isDayOff(Carbon $date): bool
    {
        return $this->meeting->daysOff()
            ->whereDate('start_at', '<=', $date)
            ->whereDate('end_at', '>=', $date)
            ->exists();
    }

    private function isSlotUnavailable(Carbon $start, Carbon $end): bool
    {
        return $this->meeting->daysOff()
            ->whereDate('start_at', '<=', $start)
            ->whereDate('end_at', '>=', $end)
            ->exists();
    }

    // Booking Methods
    public function bookSlot(string $slot): void
    {
        $this->selectedSlot = $slot;
        session()->flash('success', "You have selected the time slot: {$slot}");
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->autofocus(),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(),
                Textarea::make('note')
                    ->columnSpan(2)
                    ->maxLength(500),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function createAppointment(): void
    {
        $data = $this->form->getState();

        Appointment::create([
            'meeting_id' => $this->meeting->getKey(),
            'guest_name' => $data['name'],
            'guest_email' => $data['email'],
            'guest_note' => $data['note'],
            'appointment_at' => $this->date->toDateString(),
            'appointment_time' => $this->selectedSlot,
            'status' => AppointmentStatus::Pending->value,
        ]);

        Notification::make()
            ->title('Appointment booked successfully')
            ->success()
            ->send();

        $this->form->fill();
    }
}
