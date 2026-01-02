<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    protected $table = 'users_data';

    // IMPORTANT: allow mass insert
    protected $fillable = [
        'name',
        'email',
        'mobile'
    ];

    // Disable timestamps if not needed (faster insert)
    public $timestamps = true;
}
