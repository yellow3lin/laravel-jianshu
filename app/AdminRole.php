<?php

namespace App;


class AdminRole extends Model
{
    protected $table = 'admin_roles';
    protected $fillable= ['name', 'description', 'created_at', 'updated_at'];
    public $timestamps = true;
    //当前角色的所有权限
    public function permissions(){
        return $this->belongsToMany('\App\AdminPermission', 'admin_permission_roles', 'permission_id', 'role_id')->withPivot(['permission_id', 'role_id']);
    }

    //给角色授权
    public function grantPermission($permission){
        return $this->permissions()->save($permission);
    }

    //删除角色权限
    public function deletePermission($permission){
        return $this->permissions()->detach($permission);
    }

    //判断角色是否有权限
    public function hasPermission($permission){
        return $this->permissions()->contains($permission);
    }
}
