<?php
/**
 * Created by PhpStorm.
 * User: h
 * Date: 2017/9/2
 * Time: 21:37
 */

namespace App\Admin\Controllers;

use App\Post;

class PostController extends Controller
{
    public function index(){
        //状态为0的文章
        $posts = Post::where('status', 0)->orderBy('created_at', 'desc')->paginate(4);
        return view('/admin/post/index', compact('posts'));
    }

    //修改文章状态
    public function status(Post $post){
        $this->validate(request(), [
            'status' => 'required|in:-1,1',
        ]);
        $post->status = request('status');
        $post->save();
        return [
            'error' => 0,
            'mag' => ''
        ];
    }
}