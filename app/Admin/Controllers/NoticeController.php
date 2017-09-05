<?php
/**
 * Created by PhpStorm.
 * User: h
 * Date: 2017/9/4
 * Time: 7:55
 */

namespace App\Admin\Controllers;


use App\Jobs\SendReminderEmail;
use App\Notice;

class NoticeController extends Controller
{
//index', 'create', 'store'
    public function index(){
        $notices = Notice::all();
        return view('/admin/notice/index', compact('notices'));
    }

    public function create(){
        return view('/admin/notice/add');
    }

    public function store(){
        $this->validate(request(), [
            'title' => 'required|min:3',
            'content' => 'required|min:3'
        ]);

        $notice = Notice::create(request(['title', 'content']));
        dispatch(new SendReminderEmail($notice));
        return redirect('/admin/notices');
    }
}