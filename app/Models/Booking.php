<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Booking\Booking as FilamentBooking;

final class Booking extends FilamentBooking
{
    protected $table = 'booking_bookings';

    protected $fillable = [
        'number',
        'google_event_id',
        'service_id',
        'service_user_id',
        'booking_user_id',
        'admin_id',
        'booking_client_id',
        'booking_location_id',
        'booking_calendar_id',
        'total_price',
        'currency',
        'status',
        'shipping_price',
        'shipping_method',
        'service_date',
        'start_time',
        'end_time',
        'starts_at',
        'ends_at',
        'notes',
        'service_note',
        'is_active',
        'notified_at',
        'confirmed_at',
        'completed_at',
        'schedulable_type',
        'schedulable_id',
        'title',
        'description',
        'category',
        'location',
        'color',
    ];
}
