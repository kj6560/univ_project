<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplates extends Model
{
    public $table = "email_templates";
    use HasFactory; 
    protected $fillable = [
        'template_name',
        'template_data'
    ];
}
