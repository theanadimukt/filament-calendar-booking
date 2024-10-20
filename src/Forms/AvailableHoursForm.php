<?php

namespace Theanadimukt\CalendarBooking\Forms;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TimePicker;
use Theanadimukt\CalendarBooking\Enums\Day;

class AvailableHoursForm
{
    public static function make(Day $day): array
    {
        return [
            Repeater::make('availableHours' . $day->label())
                ->label('')
                ->addActionLabel('Add available hours')
                ->relationship('availableHours', fn ($query) => $query->forDay($day->value))
                ->grid()
                ->defaultItems(0)
                ->mutateRelationshipDataBeforeFillUsing(function (array $data) use ($day): array {
                    $data['day'] = $day->value;

                    return $data;
                })->schema([
                    TimePicker::make('start_time')
                        ->seconds(false)
                        ->minutesStep(15)
                        ->required(),
                    TimePicker::make('end_time')
                        ->seconds(false)
                        ->after('start_time')
                        ->minutesStep(15)
                        ->required(),
                ]),
        ];
    }
}
