<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProducts extends Model
{
    use HasFactory;
    protected $table='order_details';
    protected $fillable=['product_id','product_name','product_color','product_size','quantity','price','price_total','id_order'];
    public function image(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(ImagesProduct::class,'product_id','id_product');
    }
    public function color(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(ProductColor::class,'product_color','id');
    }

    public function size(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(ProductSize::class,'product_size','id');
    }
}
