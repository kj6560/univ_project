<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletionRequest extends Model
{
    use HasFactory;
    public $table = "delete_requests";
    protected $fillable = ['user_id', 'reason','status','source'];
}
