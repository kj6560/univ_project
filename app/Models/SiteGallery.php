<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteGallery extends Model
{
    public $table  = 'site_gallery';
    protected $fillable = [
        'image',
        'image_priority'
    ];
    use HasFactory;
}
