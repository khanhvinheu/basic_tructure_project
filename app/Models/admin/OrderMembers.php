<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMembers extends Model
{
    use HasFactory;
    protected $table='order_member';
    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'location_text',
        'province',
        'district',
        'commune',
        'note',
    ];
}
