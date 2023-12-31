<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property string $onesignal_id
 */
class User extends Authenticatable
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'onesignal_id'
    ];
}
