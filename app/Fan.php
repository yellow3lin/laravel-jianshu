<?php

namespace App;



class Fan extends Model
{
    protected $table = "fans";

    //粉丝用户
    public function fuser(){
        return $this->hasOne('App\User', 'id', 'fan_id');
    }

    //明星用户
    public function suser(){
        return $this->hasOne('App\User', 'id', 'star_id');
    }
}
