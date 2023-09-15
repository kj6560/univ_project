<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppExceptions extends Model
{
    use HasFactory;
    public $table = "app_exceptions";
    protected $fillable = [
        'exception_user',
        'exception_message',
        'exception_location',
        'status',
        'source'
    ];
}
