<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index(){
        return view('register/index');
    }

    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required|string|max:20|min:2|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);
        $password = bcrypt(request('password'));
        $name = request('name');
        $email = request('email');
        $user = \App\User::create(compact('name', 'email', 'password'));
        if ($user) {
            return redirect('/login');
        }
    }
}
