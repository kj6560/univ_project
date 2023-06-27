<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventResult extends Model
{
    public $table = "event_result";
    protected $fillable = [
        'user_id',
        'event_id',
        'event_result_key',
        'event_result_value',
    ];
    use HasFactory;
}
