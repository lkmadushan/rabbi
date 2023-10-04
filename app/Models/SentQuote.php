<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $user_id
 * @property int $quote_id
 * @property Carbon $sent_at
 */
class SentQuote extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'sent_at' => 'datetime:Y-m-d',
    ];
}
