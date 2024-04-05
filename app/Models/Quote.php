<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $topic
 * @property string $content
 * @property Carbon $scheduled_at
 * @property string $source
 */
class Quote extends Model
{
    use HasFactory;
}
