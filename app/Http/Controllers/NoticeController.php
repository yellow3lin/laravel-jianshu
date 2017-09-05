<?php
/**
 * Created by PhpStorm.
 * User: h
 * Date: 2017/9/4
 * Time: 11:30
 */

namespace App\Http\Controllers;


class NoticeController extends Controller
{
    public function index(){
        $user = \Auth::user();
        $notices = $user->notices;
        return view('notice/index', compact('notices'));
    }
}