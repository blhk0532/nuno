<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\SwedishDateCast;
use App\Enums\Outcomes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class RingaData extends Model
{
    /** @use HasFactory<\Database\Factories\RatsitDataFactory> */
    use HasFactory;

    protected $table = 'ringa_data';

    protected $guarded = [];

    protected $casts = [
        'fodelsedag' => SwedishDateCast::class,
        'telefon' => 'string',
        'telfonnummer' => 'array',
        'epost_adress' => 'array',
        'bolagsengagemang' => 'array',
        'personer' => 'array',
        'foretag' => 'array',
        'grannar' => 'array',
        'fordon' => 'array',
        'hundar' => 'array',
        'is_active' => 'boolean',
        'is_hus' => 'boolean',
        'is_telefon' => 'boolean',
        'is_queued' => 'boolean',
        'is_outcome' => 'boolean',
        'longitude' => 'decimal:7',
        'latitud' => 'decimal:7',
        'attempts' => 'integer',
        'booked_at' => 'datetime',
        'aterkom_at' => 'datetime',
        'available_at' => 'datetime',
        'retry_count' => 'integer',
    ];

    protected $fillable = [
        'gatuadress',
        'postnummer',
        'postort',
        'forsamling',
        'kommun',
        'kommun_ratsit',
        'lan',
        'adressandring',
        'fodelsedag',
        'personnummer',
        'stjarntacken',
        'alder',
        'kon',
        'civilstand',
        'fornamn',
        'efternamn',
        'personnamn',
        'telefon',
        'telfonnummer',
        'epost_adress',
        'bolagsengagemang',
        'agandeform',
        'bostadstyp',
        'boarea',
        'byggar',
        'fastighet',
        'personer',
        'foretag',
        'grannar',
        'fordon',
        'hundar',
        'longitude',
        'latitud',
        'google_maps',
        'google_streetview',
        'ratsit_se',
        'is_active',
        'is_telefon',
        'is_hus',
        'is_queued',
        'is_outcome',
        'user_service_id',
        'user_id',
        'team_id',
        'status',
        'outcome',
        'outcome_category',
        'attempts',
        'booking_id',
        'calendar_id',
        'booked_at',
        'aterkom_at',
        'available_at',
        'started_at',
        'expires_at',
        'user_notes',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function calendar()
    {
        return $this->belongsTo(BookingCalendar::class, 'calendar_id');
    }

    /** @return Builder<static> */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the outcome attribute as an enum instance.
     */
    public function getOutcomeAttribute($value): ?Outcomes
    {
        if (empty($value)) {
            return null;
        }

        return Outcomes::tryFrom($value);
    }
}
