<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class OutcomeSetting extends Model
{
    use HasFactory;

    protected $table = 'outcome_settings';

    protected $fillable = [
        'type',
        'category',
        'access',
        'outcome',
        'title',
        'delay_minutes',
        'max_retry_count',
        'retry',
        'quarantine',
        'quarantine_days',
        'dmc',
        'aterkom',
        'color',
        'icon',
        'description',
        'is_active',
        'order',
        'bokad',
    ];

    protected $casts = [
        'delay_minutes' => 'integer',
        'max_retry_count' => 'integer',
        'retry' => 'boolean',
        'quarantine' => 'boolean',
        'quarantine_days' => 'integer',
        'dmc' => 'boolean',
        'aterkom' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
        'bokad' => 'boolean',
    ];
}
