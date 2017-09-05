<?php
/**
 * Created by PhpStorm.
 * User: h
 * Date: 2017/8/31
 * Time: 14:34
 */

namespace App\Http\Controllers;



use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //个人介绍
    public function show(User $user){
        //个人文章
        $posts = $user->posts()->orderBy('created_at', 'desc')->take(10)->get();
        //个人关注/粉丝/文章
        $user = User::withCount(['stars', 'fans', 'posts'])->find($user->id);
        //个人关注的用户,包括关注用户的 关注/粉丝/文章数
        $stars = $user->stars();
        $susers = User::whereIn('id', $stars->pluck('star_id'))->withCount(['stars', 'fans', 'posts'])->get();
        //个人粉丝的用户,包括粉丝用户的 关注/粉丝/文章数
        $stars = $user->fans();
        $fusers = User::whereIn('id', $stars->pluck('fan_id'))->withCount(['stars', 'fans', 'posts'])->get();
        return view('user/show', compact('user', 'posts', 'susers', 'fusers'));
    }

    //关注
    public function fan(User $user)
    {
        $me = \Auth::user();
        $me ->doFan($user->id);
        return [
            'error' => 0,
            'msg' => ''
        ];
    }

    //取消关注
    public function unfan(User $user){
        $me = \Auth::user();
        $me->doUnFan($user->id);
        return [
            'error' => 0,
            'msg' => ''
        ];
    }

    //个人设置
    public function setting(){
        $me = \Auth::user();
        return view('user/setting', compact('me'));
    }

    public function settingStore(Request $request, User $user){
        $this->validate(request(), [
            'name' => 'required|min:2',
        ]);
        $name = request('name');
        if ($name != \Auth::user()->name) {
            if (User::where('name', $name)->count() >0){
                return back()->withErrors(array('massage' => '用户名称已存在'));
            }
            $user->name = request('name');
        }else{
            $user->name = $name;
        }
        if ($request->file('avatar')){
            $path = $request->file('avatar')->storePublicly(md5(\Auth::id(). time()));
            $user->avatar = '/storage/' . $path;
        }
        //dd(compact('user'));
        $user->where('id', \Auth::id())->update(['name'=>$user->name, 'avatar'=> $user->avatar]);
        return back();
    }
}