<?php

use Illuminate\Support\Facades\Route;
use Theanadimukt\CalendarBooking\Http\Controllers\MeetingController;

Route::prefix('/meetings')
    ->name('meetings.')
    ->group(function () {
        Route::get('/{slug}', [MeetingController::class, 'show'])
            ->name('show');
    });
