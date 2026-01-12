<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatsitAdresser extends Model
{
    protected $table = 'ratsit_adresser';

    protected $fillable = [
        'post_ort',
        'post_nummer',
        'gatuadress_namn',
        'personer_count',
        'foretag_count',
        'personer_link',
        'foretag_link',
    ];

    protected function casts(): array
    {
        return [
            'personer_count' => 'integer',
            'foretag_count' => 'integer',
        ];
    }
}
