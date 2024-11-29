<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UserSignatureTrait;
//use Illuminate\Database\Eloquent\SoftDeletes;


class Products extends Model
{
//    use UserSignatureTrait;
//    use SoftDeletes;
    use HasFactory;
    protected $fillable = ['id','name','id_category','detail','description','discount','trade_mark','status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function category(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Categorys::class, 'id_category', 'id');
    }

    public function optionsProduct(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(OptionsProduct::class, 'id_product', 'id');
    }

    public function imagesProduct(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(ImagesProduct::class, 'id_product', 'id');
    }

}
