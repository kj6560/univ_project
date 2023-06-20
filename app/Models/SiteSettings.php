<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    public $table = "site_settings";
    use HasFactory; 
    protected $fillable = [
        'site_key',
        'site_value',
        
    ];
}
