<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Modules;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $list_modules=array_map(function ($role) {                
            return json_decode($role['ListModule'],true);
        }, $this->role->toArray());
        
        $modules = Modules::whereIn('code', $list_modules[0])->get()->toArray();      
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'privatekey' => $this->privatekey,
            'publickey' => $this->publickey,
            'signature' => $this->signature,
            'hinhanhchuky' => $this->hinhanhchuky,
            // 'avatar' => $this->avatar,
            //    'roles' => array_map(function ($role) {
            //        return $role['name'];
            //    }, $this->roles->toArray()),
            //    'permissions' => array_map(function ($permission) {
            //        return $permission['name'];
            //    }, $this->getAllPermissions()->toArray()),
              'roles' => ['admin'],
              'ListModule'=>array_map(function ($role) {                
                            return json_decode($role['ListModule'],true);
                        }, $this->role->toArray()),
              'ListAction'=>array_map(function ($role) {                
                            return json_decode($role['ListAction'],true);
                        }, $this->role->toArray()),
              'ModuleDefault'=>$this->moduleDefault,
              'ArrayModule'=>$modules        
        ];
    }
}
