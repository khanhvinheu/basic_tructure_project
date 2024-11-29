<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\admin\TaskTypes;

class TaskManagers extends Model
{
    use HasFactory;

    protected $fillable = [        
        'title',
        'task_detail',
        'task_type',     
        'note',
        'assign_to',
        'create_by',
        'status',
        'progress'       
    ];

    public function create_by(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(User::class, 'id', 'create_by');
    }

    public function assign_to(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(User::class, 'id', 'assign_to');
    }

    
    public function task_type(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(TaskTypes::class, 'id', 'task_type');
    }

}
