<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatsitPostorter extends Model
{
    protected $table = 'ratsit_postorter';

    protected $fillable = [
        'post_ort',
        'post_nummer',
        'personer_count',
        'foretag_count',
        'personer_link',
        'foretag_link',
        'personer_kommun',
        'foretag_kommun',
        'personer_link_status',
        'foretag_link_status',
    ];

    protected function casts(): array
    {
        return [
            'personer_count' => 'integer',
            'foretag_count' => 'integer',
            'personer_link_status' => 'boolean',
            'foretag_link_status' => 'boolean',
        ];
    }
}
