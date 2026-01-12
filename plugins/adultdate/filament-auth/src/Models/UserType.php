<?php

namespace Adultdate\FilamentUser\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserType extends Model
{
    use HasFactory;

    protected $table = 'user_types';

    protected $fillable = [
        'slug',
        'label',
    ];

    public $timestamps = false;
}
