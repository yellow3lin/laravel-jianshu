<?php
/**
 * Created by PhpStorm.
 * User: h
 * Date: 2017/8/28
 * Time: 16:45
 */

namespace App;


class PostTopic extends Model
{
    protected $table = "post_topics";

    public function scopeInTopic($query, $topic_id){
        return $query->where('topic_id', $topic_id);
    }
}