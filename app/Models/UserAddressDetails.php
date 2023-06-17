<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddressDetails extends Model
{
    public $table = "user_address_details";
    use HasFactory; 
    protected $fillable = [
        'user_id',
        'address_line1',
        'city',
        'state',
        'pincode'
    ];
} 