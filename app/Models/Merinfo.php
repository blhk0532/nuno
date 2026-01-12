<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merinfo extends Model
{
    /** @use HasFactory<\Database\Factories\MerinfoFactory> */
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'short_uuid',
        'name',
        'givenNameOrFirstName',
        'personalNumber',
        'pnr',
        'address',
        'gender',
        'is_celebrity',
        'has_company_engagement',
        'number_plus_count',
        'phone_number',
        'url',
        'same_address_url',
    ];

    protected function casts(): array
    {
        return [
            'pnr' => 'array',
            'address' => 'array',
            'is_celebrity' => 'boolean',
            'has_company_engagement' => 'boolean',
            'number_plus_count' => 'integer',
            'phone_number' => 'array',
        ];
    }
}
