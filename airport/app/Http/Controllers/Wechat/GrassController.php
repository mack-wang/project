<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use App\Models\ActivityQuestion;
use App\Models\ActivityTask;
use App\Models\Grass;
use App\Models\GrassAttr;
use App\Models\GrassEveryday;
use App\Models\ResultTask;
use App\Models\Shop;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\UserInfo;
use App\Models\UserSignIn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class GrassController extends Controller
{
    public function show($user_id)
    {
        if (Auth::guard('wechat')->check()) {
            $exists = GrassEveryday::where('user_id', $user_id)
                ->whereDate('created_at', date('Y-m-d'))
                ->exists();
            if ($exists) {
                return 2;
            } else {
                return 1;
            }
        } else {
            return 0;
        }
    }

    public function getExp($user_id)
    {
        GrassEveryday::create(['user_id' => $user_id]);
        return 1;
    }

    public function index()
    {
        $id = session('user_id');
        $user = User::with('user_infos', 'user_wechats', 'grass_attrs')->find($id);
        $grasses = Grass::where('user_id', $id)
            ->whereColumn('water', '<', 'total')
            ->get();
        $count = Grass::where('user_id', $id)
            ->whereColumn('water', 'total')
            ->count();

        $tasked = ResultTask::where('user_id', $id)
            ->pluck('activity_id')
            ->toArray();

        $tasks = ActivityTask::where('type', 'all')
            ->whereNotIn('activity_id', $tasked)
            ->orWhere('type', Shop::find($user->shop_id)->type)
            ->whereNotIn('activity_id', $tasked)
            ->orderBy('top', 'desc')
            ->take(4)
            ->get();


        $user_tasks = ResultTask::where('user_id', $id)
            ->with('activities', 'activity_tasks')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('wechat.grass.grass', [
            'user' => $user,
            'grasses' => $grasses,
            'count' => $count,
            'tasks' => $tasks,
            'user_tasks' => $user_tasks,
        ]);
    }

    public function water($id)
    {
        $user_id = session('user_id');
        $attr = GrassAttr::where('user_id', $user_id)->first();
        if ($attr->water == 0) {
            return Response::json(['state' => 'error', 'message' => '亲，没水啦！']);
        }

        //用户经验加100
        $userInfo = UserInfo::where('user_id', $user_id)->first();
        $exp = $userInfo->exp;
        if ($exp == 900 ||
            $exp == 1900 ||
            $exp == 2900 ||
            $exp == 3900 ||
            $exp == 4900
        ) {
            $userInfo->increment('level');
            $userInfo->increment('exp', 100);
        } elseif ($exp >= 5000) {
            return Response::json(['state' => 'error', 'message' => '亲，你已经满级了！']);
        } else {
            $userInfo->increment('exp', 100);
        }

        //水减少100
        GrassAttr::where('user_id', $user_id)->decrement('water', 100);

        //草的水加100
        Grass::find($id)->increment('water', 100);

        return Grass::where('id', $id)->get(['water', 'total'])->toJson();
    }

    public function plant()
    {
        GrassAttr::where('user_id', session('user_id'))->decrement('seed');

        $grass = Grass::create([
            'user_id' => session('user_id'),
            'total' => 1000,
            'updated_at' => date("Y-m-d H:i:s", strtotime("-1 day")),//让用户种下后还可以直接浇水
        ]);

        return $grass->toJson();
    }

    public function getDaily()
    {
        $id = session('user_id');
        $isSignIn = UserSignIn::where('user_id',$id)
            ->whereDate('created_at', date("Y-m-d"))
            ->exists();
        if(!$isSignIn){
            $userInfo = UserInfo::where('user_id', $id)->first();
            $exp = $userInfo->exp;
            if ($exp == 900 ||
                $exp == 1900 ||
                $exp == 2900 ||
                $exp == 3900 ||
                $exp == 4900
            ) {
                $userInfo->increment('level');
                $userInfo->increment('exp', 100);
            } elseif ($exp >= 5000) {
                return back();
            } else {
                $userInfo->increment('exp', 100);
            }

            UserSignIn::create([
                'user_id'=>$id
            ]);
            return back();
        }else{
            return back();
        }

    }
}
