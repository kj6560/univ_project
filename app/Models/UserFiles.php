<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFiles extends Model
{
    protected $table = 'user_files';
    protected $fillable = [
        'user_id',
        'file_type',
        'file_path',
        'title',
        'description',
        'tags'
    ];
    use HasFactory;
}
