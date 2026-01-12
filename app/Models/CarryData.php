<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarryData extends Model
{
    /** @use HasFactory<\Database\Factories\CarryDataFactory> */
    use HasFactory;

    protected $table = 'carry_data';

    protected $fillable = [
        'person_lopnr',
        'personnr',
        'kon',
        'civilstand',
        'namn',
        'fornamn',
        'efternamn',
        'adress',
        'co_adress',
        'postnr',
        'ort',
        'telefon',
        'mobiltelefon',
        'telefax',
        'epost',
        'epost_privat',
        'epost_sekundar',
    ];
}
