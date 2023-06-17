<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPersonalDetails extends Model
{
    public $table = "user_personal_details";
    use HasFactory; 
    protected $fillable = [
        'user_id',
        'image',
        'birthday',
        'gender',
        'married',
        'height',
        'weight'
    ];
} 