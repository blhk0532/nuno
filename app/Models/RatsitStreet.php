<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatsitStreet extends Model
{
    protected $table = 'ratsit_streets';

    protected $fillable = [
        'street_name',
        'person_count',
        'postal_code',
        'city',
        'url',
        'scraped_at',
    ];

    protected $casts = [
        'scraped_at' => 'datetime',
        'person_count' => 'integer',
    ];

    public function persons()
    {
        return $this->hasMany(RatsitPerson::class, 'street', 'street_name');
    }
}
