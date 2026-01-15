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
        'confirmation_sms'
    ];

    /**
     * Default attribute values to ensure attributes exist when not present in DB.
     * This prevents MissingAttributeException when accessing optional columns
     * before migrations have been run or columns are null.
     *
     * @var array
     */
    protected $attributes = [
        'confirmation_sms' => null,
        'confirmation_email' => null,
        'confirmation_sms_number' => null,
        'confirmation_email_address' => null,
        'telavox_jwt' => null,
        'calendar_timezone' => null,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'opening_hour_start' => 'datetime',
        'opening_hour_end' => 'datetime',
        'calendar_weekends' => 'boolean',
        'calendar_theme' => CalendarTheme::class,
    ];
}
