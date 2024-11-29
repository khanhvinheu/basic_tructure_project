<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dotCaps extends Model
{
    use HasFactory;
    protected $table = 'dotCaps';
    protected $fillable = [
        'maDot',
        'thoiGianCap',
        'ghiChu',
    ];
}
