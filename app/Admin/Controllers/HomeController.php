<?php
/**
 * Created by PhpStorm.
 * User: h
 * Date: 2017/9/2
 * Time: 14:40
 */

namespace App\Admin\Controllers;


class HomeController extends Controller
{
    public function index(){

        return view('/admin/home/index');
    }
}