<?php

namespace Theanadimukt\CalendarBooking\Resources\MeetingResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Theanadimukt\CalendarBooking\Resources\MeetingResource;

class ListMeetings extends ListRecords
{
    protected static string $resource = MeetingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
