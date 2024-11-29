<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorys extends Model
{
    use HasFactory;



    // protected $hidden = [
    //     'password', 'remember_token',
    // ];
    protected $fillable = [
        'title',
        'idParent',
        'img',
        'level',
        'hidden'
    ];

    // public function children(){
    //     return $this->hasMany( 'App\Models\admin\Categorys', 'idParent', 'id' );
    // }
    // public function parent(){
    //     return $this->hasOne( 'App\Models\admin\Categorys', 'id', 'idParent' );
    // }

    //

    public function child()
    {
        return $this->hasMany(Categorys::class, 'idParent');
    }

    // Recursive children
    public function children()
    {
        return $this->hasMany(Categorys::class, 'idParent')
            ->with('children');
    }

    // One level parent
    public function parent()
    {
        return $this->belongsTo(Categorys::class, 'idParent');
    }

    // Recursive parents
    public function parents() {
        return $this->belongsTo(Categorys::class, 'idParent')
            ->with('parent');
    }

    public function getPathAttribute($data)
    {
        $path = [];
        if ($data->parent_id) {
            $parent = $data->parent;
            $parent_path = $parent->path;
            $path = array_merge($path, $parent_path);
        }
        $path[] = $data->name;
        return $path;
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function products(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Products::class, 'id_category', 'id');
    }
}
