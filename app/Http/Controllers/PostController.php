<?php
/**
 * Created by PhpStorm.
 * User: h
 * Date: 2017/8/28
 * Time: 11:09
 */

namespace App\Http\Controllers;


use App\Comment;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //文章列表
    public function index(){
        $posts = Post::orderBy('created_at', 'desc')->withCount(['zans', 'comments'])->with(['user'])->paginate(5);
        return view('posts/index', compact('posts'));
    }

    //文章详情
    public function show(Post $post){
        return view('posts/show', compact('post'));
    }

    //文章创建
    public function create(){
        return view('posts/create');
    }

    //文章编辑
    public function edit(Post $post){
        return view('posts/edit', compact('post'));
    }

    //文章修改
    public function update(Request $request, Post $post){
        $this->validate($request, [
            'title' => 'required|max:255|min:4',
            'content' => 'required|min:100',
        ]);
        $this->authorize('update', $post);
        $post->where('id', $post->id)->update(request(['title', 'content']));
        return redirect("/posts/{$post->id}");
    }

    public function delete(Post $post){
        $this->authorize('delete', $post);
        $post->delete();
        return redirect("/posts");
    }

    //文章添加验证
    public function store(Request $request){

        $this->validate($request, [
            'title' => 'required|max:255|min:4',
            'content' => 'required|min:100',
        ]);
        $params = array_merge(request(['title', 'content']), ['user_id' => \Auth::id()]);;
        Post::create($params);
        return redirect('/posts');
    }

    //图片上传
    public function imageUpload(Request $request){
        $path = $request->file('wangEditorH5File')->storePublicly(md5(\Auth::id() . time()));
        return asset('storage/'. $path);
    }

    //文章评论保存
    public function comment(){
        $this->validate(request(), [
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|min:10',
        ]);
        $user_id = \Auth::id();
        $params = array_merge(request(['post_id', 'content']), compact('user_id'));
        Comment::create($params);
        return back();
    }

    //点赞
    public function zan(Post $post){
        $zan = new \App\Zan();
        $zan->user_id = \Auth::id();
        $post->zans()->save($zan);
        return back();
    }

    //取消点赞
    public function unzan(Post $post){
        $post->zan(\Auth::id())->delete();
        return back();
    }

    //文章搜索
    public function search(){
        $this->validate(request(), [
            'query' => 'required'
        ]);
        $query = request('query');
        $posts = Post::search($query)->paginate(10);
        return view('posts/search', compact('posts', 'query'));
    }
}