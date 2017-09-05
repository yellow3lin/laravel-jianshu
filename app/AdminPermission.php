<?php

namespace App;


class AdminPermission extends Model
{
    protected $fillable= ['name', 'description'];
    protected $table= "admin_permissions";

    //权限属于哪个角色
    public function roles(){
        return $this->belongsToMany('\App\AdminRole', 'admin_permission_roles', 'role_id', 'permission_id')->withPivot(['role_id', 'permission_id']);
    }
}
