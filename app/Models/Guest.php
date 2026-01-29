<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'invite_code',
        'max_guest',
        'confirmed_count',
        'is_confirmed',
        'sent_ant'
    ];
}
