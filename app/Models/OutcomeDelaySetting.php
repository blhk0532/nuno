<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class OutcomeDelaySetting extends Model
{
    protected $table = 'outcome_delay_settings';

    protected $fillable = ['outcome', 'delay_minutes', 'description', 'is_active', 'max_retry_count'];

    protected $casts = [
        'delay_minutes' => 'integer',
        'max_retry_count' => 'integer',
        'is_active' => 'boolean',
    ];
}
