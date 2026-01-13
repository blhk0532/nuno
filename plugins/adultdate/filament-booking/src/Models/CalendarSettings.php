<?php

declare(strict_types=1);

namespace Adultdate\FilamentBooking\Models;

use Adultdate\FilamentBooking\Enums\CalendarTheme;
use Adultdate\FilamentBooking\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class CalendarSettings extends Model
{
    protected $fillable = [
        'user_id',
        'opening_hour_start',
        'opening_hour_end',
        'confirmation_sms',
        'confirmation_email',
        'calendar_weekends',
        'calendar_theme',
        'confirmation_sms_number',
        'confirmation_email_address',
        'telavox_jwt',
        'calendar_timezone',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'opening_hour_start' => 'datetime',
            'opening_hour_end' => 'datetime',
            'calendar_weekends' => 'boolean',
            'calendar_theme' => CalendarTheme::class,
        ];
    }
}
