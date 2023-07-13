<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventGallery extends Model
{
    use HasFactory;
    public $table = "event_gallery";
    protected $fillable = [
        'event_id',
        'image',
        'image_priority',
        'event_video',
        'video_priority'
    ];
}
