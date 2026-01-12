<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatsitAdress extends Model
{
    use HasFactory;

    protected $table = 'ratsit_adresser';

    protected $guarded = [];

    protected $casts = [
        'personer_count' => 'integer',
        'foretag_count' => 'integer',
    ];
}
