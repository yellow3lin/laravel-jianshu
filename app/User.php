<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //文章
    public function posts(){
        return $this->hasMany('\App\Post', 'user_id', 'id');
    }

    //关注
    public function stars(){
        return $this->hasMany('\App\Fan','fan_id', 'id');
    }

    //我的粉丝
    public function fans(){
        return $this->hasMany('\App\Fan', 'star_id', 'id');
    }

    //关注某人
    public function doFan($uid){
        $fan = new \App\Fan();
        $fan->fan_id = \Auth::id();
        $fan->star_id = $uid;
        return $this->stars()->save($fan);
    }
    //取消关注
    public function doUnFan($uid){
        $fan = new \App\Fan();
        $fan->fan_id= \Auth::id();
        $fan->star_id = $uid;
        return $this->stars()->where(['fan_id'=>$fan->fan_id, 'star_id'=>$fan->star_id])->delete();
    }

    //是否被uid关注了
    public function hasFan($uid){
        return $this->fans()->where('fan_id', $uid)->count();
    }

    //是否关注了uid
    public function hasStar($uid){
        return $this->stars()->where('star_id', $uid)->count();
    }

    //收到的通知
    public function notices(){
        return $this->belongsToMany('\App\Notice', 'user_notices', 'user_id', 'notice_id')->withPivot(['user_id', 'notice_id']);
    }

    //添加通知
    public function addNotice($notice){
        return $this->notices()->save($notice);
    }

    //删除通知
    public function deleteNotice($notice){
        return $this->notices()->detach($notice);
    }


}
