<?php
/**
 * Created by PhpStorm.
 * User: h
 * Date: 2017/9/3
 * Time: 11:17
 */

namespace App\Admin\Controllers;


use App\AdminPermission;

class permissionController extends Controller
{
    //权限列表
    public function index(){
        $permissions = AdminPermission::paginate(10);
        return view('/admin/permission/index', compact('permissions'));
    }

    //添加权限
    public function create(){
        return view('/admin/permission/add');
    }

    public function store(){
        $this->validate(request(), [
            'name' => 'required|min:3',
            'description' => 'required'
        ]);
        AdminPermission::create(request(['name', 'description']));
        return redirect('/admin/permissions');
    }
}