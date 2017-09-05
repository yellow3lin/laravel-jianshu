<?php

namespace App;


use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Searchable;


class Post extends Model
{
    use Searchable;
    protected $table = 'posts';
    protected $fillable = ['title', 'content', 'user_id'];

    //搜索类型
    public function searchableAs()
    {
        return 'posts_index';
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }

    //评论
    public function comments(){
        return $this->hasMany('\App\Comment')->orderBy('created_at', 'desc');
    }

    //作者
    public function user(){
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }

    //点赞
    public function zans(){
        return $this->hasMany('\App\Zan')->orderBy('create_at', 'desc');
    }

    //判断用户是否给文章点赞
    public function zan($user_id){
        return $this->hasOne('\App\Zan')->where('user_id', $user_id);
    }

    //文章主题
    public function topic(){
        return $this->belongsToMany('\App\Topic', 'post_topics', 'post_id', 'topic_id')->withPivot(['topic_ic', 'post_id']);
    }

    public function postTopics(){
        return $this->hasMany('\App\PostTopic', 'post_id', 'id');
    }

    //不属于某个专题的文章
    public function scopeTopicNotBy(Builder $query, $topic_id){
        return $query->doesntHave('postTopics', 'and', function ($q) use ($topic_id){
            $q->where('topic_id', $topic_id);
        });
    }

    //属于某个作者的文章
    public function scopeAuthorBy(Builder $query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    //全局scope的方式
    protected static function boot(){
        parent::boot();
        static::addGlobalScope("avaiable", function (Builder $builder){
            $builder->whereIn('status', [0,1]);
        });
}
}
