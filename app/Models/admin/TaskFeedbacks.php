<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\admin\TaskFeedbacks;
use App\Models\User;


class TaskFeedbacks extends Model
{
    use HasFactory;
    protected $fillable = [        
        'feedback',     
        'id_task',     
        'create_by',     
        'id_parent',     
    ];
    public function create_by(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(User::class, 'id', 'create_by');
    }
    public function id_task(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(TaskManagers::class, 'id', 'id_task');
    }
     // Recursive children
     public function children()
     {
         return $this->hasMany(TaskFeedbacks::class, 'id_parent')
             ->with('children');
     }
 
     // One level parent
     public function parent()
     {
         return $this->belongsTo(TaskFeedbacks::class, 'id_parent');
     }
 
     // Recursive parents
     public function parents() {
         return $this->belongsTo(TaskFeedbacks::class, 'id_parent')
             ->with('parent');
     }


}
