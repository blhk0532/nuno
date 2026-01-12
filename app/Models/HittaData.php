<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HittaData extends Model
{
    use HasFactory;

    protected $table = 'hitta_data';

    protected $fillable = [
        'personnamn',
        'alder',
        'kon',
        'gatuadress',
        'postnummer',
        'postort',
        'telefon',
        'telefonnummer',
        // legacy/DB column name is 'telefonnumer' (typo) - accept both and map via accessors
        'telefonnumer',
        'karta',
        'link',
        'bostadstyp',
        'bostadspris',
        'is_active',
        'is_telefon',
        'is_ratsit',
        'is_hus',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_telefon' => 'boolean',
            'is_ratsit' => 'boolean',
            'is_hus' => 'boolean',
            // DB column is 'telefonnumer' (note spelling) — cast that column to array
            'telefonnumer' => 'array',
        ];
    }

    /**
     * Virtual accessor to expose telefonnummer while the DB column is named telefonnumer.
     */
    public function getTelefonnummerAttribute()
    {
        return $this->getAttribute('telefonnumer');
    }

    /**
     * Virtual mutator so assigning ->telefonnummer will write to telefonnumer column.
     */
    public function setTelefonnummerAttribute($value)
    {
        $this->setAttribute('telefonnumer', $value);
    }
}
