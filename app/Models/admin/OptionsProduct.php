<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OptionsProduct extends Model
{
    use HasFactory;
    protected $table = 'options_product';
    protected $fillable = ['id','id_color','id_size','list_size','price','total','id_product','image'];


    public function products(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Products::class, 'id_product', 'id');
    }

    public function color(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(ProductColor::class,'id_color','id');
    }

    public function size(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(ProductSize::class,'id_size','id');
    }
}
