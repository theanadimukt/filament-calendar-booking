<?php

namespace Theanadimukt\CalendarBooking\Resources\MeetingResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Theanadimukt\CalendarBooking\Resources\MeetingResource;

class EditMeeting extends EditRecord
{
    protected static string $resource = MeetingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
