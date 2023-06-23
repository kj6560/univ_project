<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    use HasFactory;
    public $table = 'user_activity_log';
    protected $fillable = [
        'user_id',
        'activity_id',
        'ip_address',
    ];
}
