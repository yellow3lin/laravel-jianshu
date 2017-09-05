<?php

namespace App;

use App\AdminRole;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    protected $fillable = ['name', 'password'];
    protected $hidden = ['password'];
    protected $rememberTokenName = '';

    //用户具有的角色
    public function roles(){
        return $this->belongsToMany('\App\AdminRole', 'admin_role_users', 'user_id', 'role_id')->withPivot(['user_id', 'role_id']);
    }

    //是否有某个角色
    public function isInRole($roles){
        return !! $roles->intersect($this->roles)->count();
    }

    //是否有权限
    public function hasPermission($permission){
        return $this->isInRole($permission->roles);
    }

    //给用户分配角色
    public function assignRole($role){
        //$role = AdminRole::where('name', $roleName)->first();
        return $this->roles()->save($role);
    }

    //删除用户和角色的关联
    public function deleteRole($role){
        return $this->roles()->detach($role);
    }
}
