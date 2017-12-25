<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class GuestLottery
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //判断用户是否已经登入

        //此处获取用户的openid，判断用户之前来过没有，来过就不用再重复获取用户的微信信息
        if (true) {
            return redirect('/wechat/lottery');
        }

        return $next($request);
    }
}
