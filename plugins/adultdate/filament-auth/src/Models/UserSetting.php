<?php

namespace Adultdate\FilamentUser\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSetting extends Model
{
    use HasFactory;

    protected $table = 'user_settings';

    protected $fillable = [
        'user_id',
        'key',
        'value',
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(\Adultdate\FilamentAuth\Models\User::class);
    }
}
