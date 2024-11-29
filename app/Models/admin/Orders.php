<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = ['order_code','payment_methods','payment_status','pack_status','check_status','note','id_member'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function member(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(OrderMembers::class, 'id_member', 'id');
    }

    public function detail(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(OrderProducts::class, 'id_order', 'id');
    }

}
