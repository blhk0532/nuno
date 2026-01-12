<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerinfoData extends Model
{
    // Use default connection; previously forced 'sqlite' which broke API tests under mysql.

    protected $table = 'merinfo_data';

    protected $fillable = [
        'personnamn',
        'alder',
        'kon',
        'gatuadress',
        'postnummer',
        'postort',
        'telefon',
        'karta',
        'link',
        'bostadstyp',
        'bostadspris',
        'is_active',
        'is_telefon',
        'is_ratsit',
        'is_hus',
        'merinfo_personer_total',
        'merinfo_foretag_total',
        'merinfo_personer_saved',
        'merinfo_foretag_saved',
        'merinfo_personer_phone_total',
        'merinfo_foretag_phone_total',
        'merinfo_personer_phone_saved',
        'merinfo_foretag_phone_saved',
        'merinfo_personer_house_saved',
        'merinfo_foretag_house_saved',
        'merinfo_personer_count',
        'merinfo_personer_queue',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_telefon' => 'boolean',
        'is_ratsit' => 'boolean',
        'is_hus' => 'boolean',
        // telefon: no cast - accepts any data type (string, array, etc.)
        'telefonnummer' => 'array',
        'telefoner' => 'array',
        'postnummer' => 'string',
        'merinfo_personer_total' => 'integer',
        'merinfo_foretag_total' => 'integer',
        'merinfo_personer_saved' => 'integer',
        'merinfo_foretag_saved' => 'integer',
        'merinfo_personer_phone_total' => 'integer',
        'merinfo_foretag_phone_total' => 'integer',
        'merinfo_personer_phone_saved' => 'integer',
        'merinfo_foretag_phone_saved' => 'integer',
        'merinfo_personer_house_saved' => 'integer',
        'merinfo_foretag_house_saved' => 'integer',
        'merinfo_personer_count' => 'integer',
        'merinfo_personer_queue' => 'integer',
    ];

    /**
     * Truncated preview of the telefon field for table display.
     * Returns an em dash when empty or placeholder.
     * Handles any data type: string, array, etc.
     */
    public function getTelefonPreviewAttribute(): string
    {
        $telefon = $this->telefon;

        // Handle different data types
        if (is_array($telefon)) {
            // Flatten nested arrays
            $phones = [];
            array_walk_recursive($telefon, function ($item) use (&$phones) {
                if (is_string($item) || is_numeric($item)) {
                    $phones[] = (string) $item;
                }
            });
            $phoneStr = implode(' | ', $phones);
        } else {
            $phoneStr = trim(preg_replace('/\s+/', ' ', (string) $telefon));
        }

        if ($phoneStr === '' || $phoneStr === 'Lägg till telefonnummer') {
            return '—';
        }

        return mb_strlen($phoneStr) > 13 ? mb_substr($phoneStr, 0, 13).'…' : $phoneStr;
    }
}
