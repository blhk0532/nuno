<?php

namespace App\Models;

use App\Casts\SwedishDateCast;
use App\Enums\Outcomes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Team;

class RingaData extends Model
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
        'longitude' => 'decimal:7',
        'latitud' => 'decimal:7',
        'attempts' => 'integer',
        'booked_at' => 'datetime',
        'aterkom_at' => 'datetime',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function calendar()
    {
        return $this->belongsTo(BookingCalendar::class, 'calendar_id');
    }

    protected $fillable = [
        'gatuadress',
        'postnummer',
        'postort',
        'forsamling',
        'kommun',
        'kommun_ratsit',
        'lan',
        'adressandring', // Date of address change from Ratsit
        'fodelsedag',
        'personnummer',
        'stjarntacken', // Zodiac sign
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
        'google_maps', // Google Maps navigation URL
        'google_streetview', // Google Street View URL
        'ratsit_se', // Source profile URL
        'is_active',
        'is_telefon',
        'is_hus',
        'is_queued',
        'user_service_id',
        'user_id',
        'team_id',
        'status',
        'outcome',
        'attempts',
        'booking_id',
        'calendar_id',
        'booked_at',
        'aterkom_at',
        'user_notes',
    ];

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

    /**
     * Set the outcome attribute, converting enum to string or handling null/empty values.
     */
    public function setOutcomeAttribute($value): void
    {
        if ($value instanceof Outcomes) {
            $this->attributes['outcome'] = $value->value;
        } elseif (empty($value)) {
            $this->attributes['outcome'] = null;
        } else {
            // Try to convert string to enum to validate it
            $enum = Outcomes::tryFrom($value);
            $this->attributes['outcome'] = $enum ? $enum->value : null;
        }
    }
}
