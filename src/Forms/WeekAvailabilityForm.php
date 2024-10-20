<?php

namespace Theanadimukt\CalendarBooking\Forms;

use Filament\Forms\Components\Section;
use Theanadimukt\CalendarBooking\Enums\Day;

class WeekAvailabilityForm
{
    public static function make(): array
    {
        $form = [];
        foreach (Day::options() as $day => $label) {
            $form[] = Section::make($label)
                ->collapsible()
                ->collapsed(fn ($state): bool => empty($state["availableHours{$label}"]))
                ->columnSpan(1)
                ->schema(AvailableHoursForm::make(Day::tryFrom($day)));
        }

        return $form;
    }
}
