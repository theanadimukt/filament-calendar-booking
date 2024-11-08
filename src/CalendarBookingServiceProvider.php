<?php

namespace Theanadimukt\CalendarBooking;

use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Theanadimukt\CalendarBooking\Components\MeetingComponent;
use Theanadimukt\CalendarBooking\Livewire\Counter;
use Theanadimukt\CalendarBooking\Testing\TestsCalendarBooking;

class CalendarBookingServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-calendar-booking';

    public static string $viewNamespace = 'filament-calendar-booking';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasRoutes($this->getRoutes())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('theanadimukt/filament-calendar-booking');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }

        $this->registerLivewireComponents();
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/filament-calendar-booking/{$file->getFilename()}"),
                ], 'filament-calendar-booking-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsCalendarBooking);
    }

    protected function getAssetPackageName(): ?string
    {
        return 'theanadimukt/filament-calendar-booking';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('filament-calendar-booking', __DIR__ . '/../resources/dist/components/filament-calendar-booking.js'),
            Css::make('filament-calendar-booking-styles', __DIR__ . '/../resources/dist/filament-calendar-booking.css'),
            Js::make('filament-calendar-booking-scripts', __DIR__ . '/../resources/dist/filament-calendar-booking.js'),
        ];
    }

    protected function getCommands(): array
    {
        return [];
    }

    protected function getIcons(): array
    {
        return [];
    }

    protected function getRoutes(): array
    {
        return ['web'];
    }

    protected function getScriptData(): array
    {
        return [];
    }

    protected function getMigrations(): array
    {
        return [
            'create_meetings_table',
            'create_meeting_available_hours_table',
            'create_meeting_days_off_table',
            'create_appointments_table',
        ];
    }

    protected function registerBladeComponents(): self
    {
        Blade::component('filament-calendar-booking:meeting', MeetingComponent::class);

        return $this;
    }

    protected function registerLivewireComponents(): void
    {
        Livewire::component('counter', Counter::class);
    }
}
