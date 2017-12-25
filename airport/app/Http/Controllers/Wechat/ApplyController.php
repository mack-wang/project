<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Article;
use App\Models\SlideImage;
use App\Models\User;
use App\Models\UserSignIn;
use EasyWeChat\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class ApplyController extends Controller
{
    //

    public function index(Application $wechat)
    {

        //判断用户是否已经登入过
        if (Auth::guard('wechat')->guest()) {
            //判断是否已经获取过用户的个人信息
            $result = $wechat->oauth->user();
            $user = User::where('openid', $result['id'])->first();
            if ($user === null) {
                $result = User::create([
                    'openid' => $result['id'],
                    'register' => 2,
                ]);
                session(['user_id' => $result->id]);
                return $wechat->oauth->scopes(['snsapi_userinfo'])->redirect();
            } elseif ($user->register === 2) {
                session(['user_id' => $user->id]);
                return $wechat->oauth->scopes(['snsapi_userinfo'])->redirect();
            }
            $user_id = $user->id;
        } else {
            $user_id = Auth::guard('wechat')->id();
        }
        //创建会话
        session(['user_id' => $user_id]);
        return redirect('/wechat/showApply');

    }


    public function getInfo(Application $wechat)
    {
        $user = $wechat->oauth->user();
        $user_id = session('user_id');
        $result = User::find($user_id);
        $result->user_wechats()->create([
            'nickname' => $user['nickname'],
            'headimgurl' => $user['avatar'],
        ])->user_wechat_infos()->create([
            'province' => $user['original']['province'],
            'city' => $user['original']['city'],
            'sex' => $user['original']['sex'],
        ]);

        $result->register = 3;
        $result->save();
        return redirect('/wechat/showApply');

    }


    public function showApply()
    {
        $user_id = session('user_id');

        $user = User::with('shops', 'user_wechats', 'user_infos')->find($user_id);

        $signIn = UserSignIn::where('user_id',$user_id)
        ->whereDate('created_at', date("Y-m-d"))
        ->exists();

        $slides = SlideImage::where('state', 1)->get();

        if ($user->shop_id != null) {
            $activity_shops = Activity::where('off', 0)
                ->where('type', $user->shops->type)
                ->where('end_at', '>', date('Y-m-d H:i:s'))
                ->with('activity_shops')
                ->get();
        } else {
            $activity_shops = null;
        }

        return view('wechat.apply', [
            'user' => $user,
            'slides' => $slides,
            'activity_shops' => $activity_shops,
            'signIn' => $signIn,
        ]);
    }

    public function applyList()
    {
        $activity_applies = Activity::where('off', 0)
            ->where('type', 'apply')
            ->where('end_at', '>', date('Y-m-d H:i:s'))
            ->with('activity_attrs', 'activity_prizes', 'activity_requires', 'result_applies', 'fetch_cigarettes')
            ->orderBy('top','desc')
            ->get();

        $activity_kills = Activity::where('off', 0)
            ->where('type', 'kill')
            ->where('end_at', '>', date('Y-m-d H:i:s'))
            ->with('activity_attrs', 'activity_prizes', 'activity_requires', 'result_applies', 'fetch_cigarettes')
            ->get();

        $reports = Activity::where('off', 0)
            ->whereIn('type', ['apply', 'kill'])
            ->where('end_at', '<', date('Y-m-d H:i:s'))
            ->with('activity_attrs', 'activity_prizes', 'activity_requires', 'result_applies', 'fetch_cigarettes')
            ->get();

        return view('wechat.apply-list', [
            'activity_applies' => $activity_applies,
            'activity_kills' => $activity_kills,
            'reports' => $reports,
        ]);
    }


    public function article($id)
    {
        return view('wechat.article', [
            'article' => Article::find($id),
        ]);
    }

}
