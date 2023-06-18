<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContactDetails extends Model
{
    public $table = "emergency_contact_details";
    use HasFactory; 
    protected $fillable = [
        'user_id',
        'address_line1',
        'city',
        'state',
        'pincode'
    ];
}
