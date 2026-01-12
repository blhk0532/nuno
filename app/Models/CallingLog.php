<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CallingLog extends Model
{
    use HasFactory;

    protected $table = 'calling_logs';

    protected $fillable = [
        'user_id',
        'call_sid',
        'target_number',
        'target_name',
        'duration_seconds',
        'started_at',
        'ended_at',
        'status',
        'recording_url',
        'notes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'duration_seconds' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
