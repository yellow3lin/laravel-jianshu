<?php
/**
 * Created by PhpStorm.
 * User: h
 * Date: 2017/8/28
 * Time: 16:36
 */

namespace App;


class Topic extends Model
{
    protected $fillable = ['name'];
    protected $table = 'topics';
    //属于该专题的所有文章
    public function posts(){
        return $this->belongsToMany('\App\Post', 'post_topics', 'topic_id', 'post_id');
    }

    //专题的文章数
    public function postTopics(){
        return $this->hasMany('\App\PostTopic', 'topic_id', 'id');
    }
}