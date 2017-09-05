<?php
/**
 * Created by PhpStorm.
 * User: h
 * Date: 2017/9/3
 * Time: 11:16
 */

namespace App\Admin\Controllers;


use App\AdminPermission;
use App\AdminRole;

class RoleController extends Controller
{
    //角色管理
    public function index(){
        $roles = AdminRole::paginate(10);
        return view('/admin/role/index', compact('roles'));
    }

    //创建角色
    public function create(){
        return view('admin/role/create');
    }

    //角色验证
    public function store(){
        $this->validate(request(), [
            'name' => 'required|min:3',
            'description' => 'required',
        ]);
        AdminRole::create(request(['name', 'description']));
        return redirect('/admin/roles');
    }

    //角色权限
    public function permission(AdminRole $role){
        $permissions = AdminPermission::all();
        $myPermissions = $role->permissions;
        return view('admin/role/permission', compact('role', 'permissions', 'myPermissions'));
    }

    //修改权限
    public function storePermission(AdminRole $role){
        $this->validate(request(), [
            'permissions' => 'required|array'
        ]);
        $permissions = AdminPermission::findMany(request('permissions'));
        $myPermissions = $role->permissions;

        //添加权限,对已经有的权限去掉
        $addPermissions = $permissions->diff($myPermissions);
        foreach ($addPermissions as $addPermission) {
            $role->grantPermission($addPermission);
        }
        //删除权限
        $deletePremissions = $myPermissions->diff($permissions);
        foreach ($deletePremissions as $deletePremission) {
            $role->deletePermission($deletePremission);
        }
        return back();
    }
}