<?php

it('can install migrations and configurations', function () {
    $this->artisan('filament-calendar-booking:install')
        ->expectsOutput('Publishing Config...')
        ->expectsOutput('Publishing Migrations...')
        ->expectsOutput('Would you like to run the migrations now? (yes/no)')
        ->expectsOutput('Would you like to star our repo on GitHub? (yes/no)')
        ->expectsOutput('filament-calendar-booking has been installed!
')
        ->assertExitCode(0);
});
