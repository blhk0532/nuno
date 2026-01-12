<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatsitPerson extends Model
{
    protected $table = 'ratsit_persons';

    protected $fillable = [
        'name',
        'age',
        'street',
        'postal_code',
        'city',
        'url',
        'scraped_at',
    ];

    protected $casts = [
        'scraped_at' => 'datetime',
        'age' => 'integer',
    ];

    public function street()
    {
        return $this->belongsTo(RatsitStreet::class, 'street', 'street_name');
    }
}
