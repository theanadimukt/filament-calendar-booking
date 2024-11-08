<?php

namespace Theanadimukt\CalendarBooking\Resources;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Theanadimukt\CalendarBooking\Forms\WeekAvailabilityForm;
use Theanadimukt\CalendarBooking\Models\Meeting;
use Theanadimukt\CalendarBooking\Resources\MeetingResource\Pages;

class MeetingResource extends Resource
{
    protected static ?string $model = Meeting::class;

    protected static ?string $navigationGroup = 'Calendar Booking';

    protected static ?string $navigationIcon = 'heroicon-o-hand-raised';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::query()->withinDateRange(now())->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Information')
                    ->schema([
                        TextInput::make('title')
                            ->required(),
                        TextInput::make('slug')
                            ->disabled(),
                        DatePicker::make('start_at')
                            ->native(false)
                            ->label('Booking Start At')
                            ->required()
                            ->minDate(now()->startOfDay())
                            ->maxDate(now()->addYears()),
                        DatePicker::make('end_at')
                            ->native(false)
                            ->label('Booking End At')
                            ->required()
                            ->minDate(now()->startOfDay())
                            ->maxDate(now()->addYears()),
                        Textarea::make('description')
                            ->columnSpan(2),
                        Select::make('owner_id')
                            ->required()
                            ->relationship(name: 'owner', titleAttribute: 'name')
                            ->searchable(['name', 'email']),
                    ]),
                Fieldset::make('Availibility')
                    ->columns(3)
                    ->schema(WeekAvailabilityForm::make()),
                Fieldset::make('Days Off')
                    ->schema([
                        Repeater::make('daysOff')
                            ->relationship()
                            ->label('')
                            ->defaultItems(0)
                            ->schema([
                                DatePicker::make('start_at')
                                    ->native(false)
                                    ->label('Start At')
                                    ->required()
                                    ->minDate(now())
                                    ->maxDate(now()->addYears()),
                                DatePicker::make('end_at')
                                    ->native(false)
                                    ->label('End At')
                                    ->required()
                                    ->minDate(now())
                                    ->maxDate(now()->addYears()),
                            ])
                            ->grid(3)
                            ->columnSpan('full')
                            ->addActionLabel('Add Day Off'),
                    ]),
                Fieldset::make('Configuration')
                    ->columns(3)
                    ->schema([
                        TextInput::make('slots_period_minutes')
                            ->label('Slots Period Minutes')
                            ->numeric()
                            ->default(15),
                        TextInput::make('appointment_per_slot')
                            ->label('Appointment Per Slot')
                            ->numeric()
                            ->default(1)
                            ->minValue(1),
                        TextInput::make('appointment_notice_days')
                            ->label('Appointment Notice Days')
                            ->numeric()
                            ->default(1)
                            ->minValue(0),
                        TextInput::make('cancellation_notice_days')
                            ->label('Cancellation Notice Days')
                            ->numeric()
                            ->default(1)
                            ->minValue(0),
                        Toggle::make('auto_acceptance')
                            ->onColor('success')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_at')
                    ->date()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('end_at')
                    ->date()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\CreateAction::make('meeting')
                    ->icon('heroicon-o-rocket-launch')
                    ->label('')
                    ->tooltip('Public page')
                    ->color('success')
                    ->url(fn (Meeting $record): string => route('meetings.show', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMeetings::route('/'),
            'create' => Pages\CreateMeeting::route('/create'),
            'edit' => Pages\EditMeeting::route('/{record}/edit'),
        ];
    }
}
