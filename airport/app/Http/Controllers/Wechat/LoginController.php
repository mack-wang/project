<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordCheckRequest;
use App\Http\Requests\UserFormRequest;
use App\Models\User;
use App\Models\UserMessageCode;
use App\Models\UserWechat;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Response;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest.apply', ['except' => 'logout']);
    }

    protected function guard()
    {
        return Auth::guard('wechat');
    }


    public function view($blade)
    {
        return view('wechat.login.' . $blade);
    }


    public function index()
    {
        //当前用户Auth未登入，所以要判断他的注册状态
        if (User::find(session('user_id'))->register == 3) {
            return view('wechat.login.login');
        } elseif (Auth::guard('wechat')->check()) {
            return redirect('wechat/home');
        } else {
            return view('wechat.login.password-login');
        }
    }

    public function gohome(Application $wechat)
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
                return $wechat->oauth->scopes(['snsapi_userinfo'])->redirect(url('/wechat/gohome/getInfo'));
            } elseif ($user->register === 2) {
                session(['user_id' => $user->id]);
                return $wechat->oauth->scopes(['snsapi_userinfo'])->redirect(url('/wechat/gohome/getInfo'));
            }
            $user_id = $user->id;
        } else {
            $user_id = Auth::guard('wechat')->id();
        }
        //创建会话
        session(['user_id' => $user_id]);
        return redirect('/wechat/home');

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
        return redirect('/wechat/home');

    }

    public function login(UserFormRequest $request)
    {
        //获取该手机号的最新的一条验证短信
        $result = UserMessageCode::where('phone', $request->phone)
            ->orderBy('created_at', 'desc')
            ->first();

        //验证短信，错误的话，返回登入
        if ($request->code != $result->code) {
            Session::flash('error', '短信验证码错误');
            return redirect('wechat/login')->withInput();
        }

        User::find(session('user_id'))->update([
            'password' => Hash::make($request->password),
        ]);

        //前去填写用户个人信息，如果未填写则算未注册
        return redirect('/wechat/register/' . $request->phone);
    }

    public function passwordLogin(PasswordCheckRequest $request)
    {
        $result = Auth::guard('wechat')->attempt([
            'id' => session('user_id'),
            'password' => $request->password
        ], true);

        if ($result) {
            return redirect('wechat/home');
        } else {
            return back()->with('error', '密码错误!')->withInput();
        }
    }


    public function passwordReset(PasswordCheckRequest $request)
    {
        //获取该手机号的最新的一条验证短信
        $result = UserMessageCode::where('phone', $request->phone)
            ->orderBy('created_at', 'desc')
            ->first();

        //验证短信，错误的话，返回重置密码
        if ($request->code != $result->code) {
            Session::flash('error', '短信验证码错误');
            return redirect('wechat/login/view/password-reset')->withInput();
        }

        $user = User::find(session('user_id'));

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('wechat')->login($user);

        return redirect('/wechat/home');
    }

    public function logout()
    {
        Auth::guard('wechat')->logout();
        return redirect('/wechat/showApply');
    }

    public function sendCode(Request $request)
    {
        $code = rand(123456, 587654);
        $result = Helper::sendMessage($request->phone, $code);
//        $code = 123456;
//        $result = 1;
        if ($result > 0) {
            UserMessageCode::create([
                'user_id' => session('user_id'),
                'phone' => $request->phone,
                'code' => $code,
            ]);
            return Response::json(['state' => 'success', 'message' => '发送成功']);
        } else {
            return Response::json(['state' => 'error', 'message' => '验证码发送失败，请稍后再试！']);
        }
    }

}
