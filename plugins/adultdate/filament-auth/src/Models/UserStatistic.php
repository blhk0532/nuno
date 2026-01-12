<?php

namespace Adultdate\FilamentUser\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserStatistic extends Model
{
    use HasFactory;

    protected $table = 'user_stats';

    protected $fillable = [
        'user_id',
        'key',
        'value',
    ];

    protected $casts = [
        'value' => 'integer',
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(\Adultdate\FilamentAuth\Models\User::class);
    }
}
