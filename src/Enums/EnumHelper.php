<?php

namespace Theanadimukt\FilamentAppointment\Enums;

use Illuminate\Support\Str;

trait EnumHelper
{
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }

    public static function options(): array
    {
        return array_combine(
            self::values(),
            array_map(fn (self $enum) => $enum->label(), self::cases())
        );
    }

    public function label(): string
    {
        return Str::headline($this->name);
    }
}
