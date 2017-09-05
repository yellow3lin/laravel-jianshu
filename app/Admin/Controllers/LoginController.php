<?php
/**
 * Created by PhpStorm.
 * User: h
 * Date: 2017/9/2
 * Time: 14:22
 */

namespace App\Admin\Controllers;


class LoginController extends Controller
{
    public function index(){
        return view('/admin/login/index');
    }

    //登录
    public function login(){
        $this->validate(request(), [
            'name' => 'required|min:2',
            'password' => 'required|min:6|max:20',
        ]);
        $user = request(['name', 'password']);
        if (\Auth::guard('admin')->attempt($user) == true) {
            return redirect('/admin/home');
        }

        return \Redirect::back()->withErrors("用户名或密码错误");
    }

    //退出
    public function logout(){
        \Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}