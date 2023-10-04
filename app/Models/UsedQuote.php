<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsedQuote extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'used_at' => 'datetime:Y-m-d',
    ];
}
