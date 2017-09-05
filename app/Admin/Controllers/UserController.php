<?php
/**
 * Created by PhpStorm.
 * User: h
 * Date: 2017/9/2
 * Time: 16:52
 */

namespace App\Admin\Controllers;

use App\AdminRole;
use App\AdminUser;

class UserController extends Controller
{
    //用户列表
    public function index(){
        $users = AdminUser::paginate(10);
        return view('/admin/user/index', compact('users'));
    }

    //创建用户
    public function create(){
        return view('/admin/user/create');
    }

    //检验数据,并保存用户信息
    public function store(){
        $this->validate(request(), [
            'name' => 'required|string|max:20|min:2|unique:admin_users',
            'password' => 'required|string|min:6|max:20',
        ]);
        $name = request('name');
        $password = bcrypt(request('password'));
        $user = AdminUser::create(compact('name','password'));
        return redirect('/admin/users');
    }

    //用户权限
    public function role(AdminUser $user){
        $roles = AdminRole::all();
        $myRoles = $user->roles;
        return view('/admin/user/role', compact('roles', 'myRoles', 'user'));
    }

    //保存权限
    public function storeRole(AdminUser $user){
        $this->validate(request(), [
            'roles' => 'required|array'
        ]);

        $roles = AdminRole::findMany(request('roles'));
        $myRoles = $user->roles;

        $addRoles = $roles->diff($myRoles);
        foreach ($addRoles as $addRole){
            $user->assignRole($addRole);
        }
        $deleteRoles = $myRoles->diff($roles);
        foreach ($deleteRoles as $deleteRole) {
            $user->deleteRole($deleteRole);
        }
        return back();
    }
}