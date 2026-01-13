<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class Booking extends Model
{
    protected $table = 'booking_bookings';

    protected $fillable = [
        'number',
        'total_price',
        'status',
        'currency',
        'booking_location_id',
        'booking_calendar_id',
        'shipping_price',
        'shipping_method',
        'notes',
        'service_note',
        'is_active',
        'notified_at',
        'confirmed_at',
        'completed_at',
        'service_id',
        'service_user_id',
        'booking_user_id',
        'booking_client_id',
        'service_date',
        'start_time',
        'end_time',
        'starts_at',
        'ends_at',
        'admin_id',
        'google_event_id',
    ];

    protected $casts = [
        'service_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
        'notified_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
        'total_price' => 'decimal:2',
        'shipping_price' => 'decimal:2',
    ];
}
