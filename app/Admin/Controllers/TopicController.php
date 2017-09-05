<?php
/**
 * Created by PhpStorm.
 * User: h
 * Date: 2017/9/3
 * Time: 20:14
 */

namespace App\Admin\Controllers;


use App\Topic;

class TopicController extends Controller
{
    public function index(){
        $topics = Topic::all();
        return view('/admin/topic/index', compact('topics'));
    }

    public function create(){
        return view('/admin/topic/add');
    }

    public function store(){
        $this->validate(request(),[
            'name' => 'required|min:2'
        ]);
        Topic::create(request(['name']));
        return redirect('/admin/topics');
    }

    public function destroy(Topic $topic){
        $topic->delete();
        return [
            'error'=> 0,
            'mag' => ''
        ];
    }
}