<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'image',
        'is_active'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
