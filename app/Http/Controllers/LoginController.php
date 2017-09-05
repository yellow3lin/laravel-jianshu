<?php
/**
 * Created by PhpStorm.
 * User: h
 * Date: 2017/8/27
 * Time: 10:39
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        if (\Auth::check()) {
            return redirect('/posts');
        }
        return view('login/index');
    }

    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6|max:20',
            'is_remember' => 'integer',
       ]);

        $user = request(['email', 'password']);
        $remember = boolval(request('is_remember'));
        if (\Auth::attempt($user, $remember) == true) {
            return redirect('/posts');
        }

        return \Redirect::back()->withErrors("邮箱或密码错误");
    }

    public function logout(){
        \Auth::logout();
        return redirect('/login');
    }
}