<?php

namespace App\Models;

use App\Casts\SwedishDateCast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatsitData extends Model
{
    /** @use HasFactory<\Database\Factories\RatsitDataFactory> */
    use HasFactory;

    protected $table = 'ratsit_data';

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
    ];

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
    ];

    /** @return Builder<static> */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Ensure telfonnummer is always returned as an array.
     * Accepts stored JSON arrays or pipe-delimited strings and normalizes to array.
     *
     * @param  mixed  $value
     */
    public function getTelfonnummerAttribute($value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if ($value === null) {
            return [];
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }

            // Fallback: pipe-delimited values -> convert to array
            $parts = array_filter(array_map('trim', explode('|', $value)));

            return array_values($parts);
        }

        // Any other type, cast to array
        return (array) $value;
    }

    /**
     * Normalize and store telfonnummer as JSON array.
     * Accepts array, JSON string, or pipe-delimited string.
     *
     * @param  mixed  $value
     */
    public function setTelfonnummerAttribute($value): void
    {
        if (is_array($value)) {
            $this->attributes['telfonnummer'] = json_encode(array_values($value));

            return;
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $this->attributes['telfonnummer'] = json_encode(array_values($decoded));

                return;
            }

            $parts = array_filter(array_map('trim', explode('|', $value)));
            $this->attributes['telfonnummer'] = json_encode(array_values($parts));

            return;
        }

        // Fallback: castable values
        $this->attributes['telfonnummer'] = json_encode(array_values((array) $value));
    }
}
