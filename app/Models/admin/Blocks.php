<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blocks extends Model
{
    use HasFactory;
    protected $name='blocks';
    protected $hidden = ['id','created_at','updated_at'];
    protected $fillable=[
        'index',
        'timestamp',
        'data',
        'previousHash',
        'hash',
        'signature',
    ];
    public $incrementing = false;
}
