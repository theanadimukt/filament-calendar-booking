<?php

namespace Theanadimukt\CalendarBooking\Tests\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return true;
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
