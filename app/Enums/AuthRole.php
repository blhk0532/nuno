<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AuthRole: string implements HasLabel, HasColor
{
    case ADMIN = 'admin';
    case SUPER = 'super';
    case MANAGER = 'manager';
    case SERVICE = 'service';
    case BOOKING = 'booking';
    case PARTNER = 'partner';
    case GUEST = 'guest';
    case USER = 'user';

    public function label(): string
    {
        return match ($this) {
            AuthRole::ADMIN => 'Administrator',
            AuthRole::SUPER => 'Super Admin',
            AuthRole::MANAGER => 'Manager',
            AuthRole::SERVICE => 'Service',
            AuthRole::BOOKING => 'Booking',
            AuthRole::PARTNER => 'Partner',
            AuthRole::GUEST => 'Guest',
            AuthRole::USER => 'User',
        };
    }

    public function getLabel(): string
    {
        return __('messages.auth_role.' . $this->value);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ADMIN => 'primary',
            self::SUPER => 'secondary',
            self::MANAGER => 'success',
            self::SERVICE => 'warning',
            self::BOOKING => 'info',
            self::PARTNER => 'gray',
            self::GUEST => 'danger',
            self::USER => 'primary',
        };
    }
}
