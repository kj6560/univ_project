<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSlider extends Model
{
    use HasFactory;
    public $table = "event_slider";
    protected $fillable = [
        'event_id',
        'image',
    ];
}
