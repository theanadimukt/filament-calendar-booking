<?php

namespace Theanadimukt\CalendarBooking\Forms;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Theanadimukt\CalendarBooking\Enums\Day;

class AvailableHoursForm
{
    public static function make(Day $day): array
    {
        return [
            Repeater::make('availableHours'.$day->label())
                ->label('')
                ->addActionLabel('Add available hours')
                ->relationship('availableHours', fn ($query) => $query->forDay($day->value))
                ->grid()
                ->defaultItems(0)
                ->schema([
                    Hidden::make('day')->default($day->value),
                    TimePicker::make('from')
                        ->seconds(false)
                        ->minutesStep(15)
                        ->required(),
                    TimePicker::make('to')
                        ->seconds(false)
                        ->after('from')
                        ->minutesStep(15)
                        ->required(),
                ]),
        ];
    }
}
