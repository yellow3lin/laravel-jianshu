<?php
/**
 * Created by PhpStorm.
 * User: h
 * Date: 2017/9/1
 * Time: 17:49
 */

namespace App\Http\Controllers;


use App\Topic;
use App\Post;
use App\PostTopic;

class TopicController extends Controller
{
    public function show(Topic $topic){
        //专题下的文章数
        $topic = Topic::withCount('postTopics')->find($topic->id);
        //专题前10条文章
        $posts = $topic->posts()->orderBy('created_at', 'desc')->take(10)->get();
        //未投稿文章
        $myposts = Post::authorBy(\Auth::id())->topicNotBy($topic->id)->get();
        return view('/topic/show', compact('topic', 'posts', 'myposts'));
    }

    public function submit(Topic $topic){
        $this->validate(request(), [
            'post_ids' => 'array'
        ]);

        $posts = \App\Post::find(request(['post_ids']));
        foreach ($posts as $post){
            if ($post->user_id != \Auth::id()){
                return back()->withErrors(array('message' => '没有权限'));
            }
        }
        $post_ids = request('post_ids');
        $topic_id = $topic->id;
        if (empty($post_ids)){
            return back()->withErrors(array('massage' => '投稿失败'));
        }
        foreach ($post_ids as $post_id){
            PostTopic::firstOrCreate(compact('topic_id', 'post_id'));
        }
        return back();
    }
}