<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    public $table = "jobs";
    protected $fillable = [
        'queue',
        'payload',
        'attempts',
        'status',
        'reserved_at',
        'available_at',
        'params_upload'

    ];
    use HasFactory;
}
