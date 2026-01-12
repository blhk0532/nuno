<?php

namespace App;

enum UserRole: string
{
    case ADMIN = 'admin';
    case SUPER_ADMIN = 'super_admin';
    case SUPERADMIN = 'superadmin';
    case MANAGER = 'manager';
    case SERVICE = 'service';
    case BOOKING = 'booking';
    case PARTNER = 'partner';
    case GUEST = 'guest';
    case AGENT = 'agent';
    case USER = 'user';

    public function label(): string
    {
        return match ($this) {
            UserRole::ADMIN => 'Administrator',
            UserRole::SUPER_ADMIN => 'Super Administrator',
            UserRole::SUPERADMIN => 'SuperAdministrator',
            UserRole::MANAGER => 'Manager',
            UserRole::SERVICE => 'Service',
            UserRole::BOOKING => 'Booking',
            UserRole::PARTNER => 'Partner',
            UserRole::GUEST => 'Guest',
            UserRole::AGENT => 'Agent',
            UserRole::USER => 'User',
        };
    }
}
