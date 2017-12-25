<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;

class Helper extends Controller
{
    //组织微信网页授权url,并跳转
    public static function header($route, $scope_type, $state)
    {
        $url = env('APP_URL') . $route;
        $appid = env('WECHAT_APPID');

        //0为base,1为userinfo
        $scope_type == 1 ? $scope = 'snsapi_userinfo' : $scope = 'snsapi_base';
        return header('location:https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $appid . '&redirect_uri=' . urlencode($url) . '&response_type=code&scope=' . $scope . '&state=' . $state . '#wechat_redirect');
    }

    //组织微信网页授权url，并返回url
    public static function url($route, $scope_type, $state)
    {
        $url = env('APP_URL') . $route;
        $appid = env('WECHAT_APPID');

        //0为base,1为userinfo
        $scope_type == 1 ? $scope = 'snsapi_userinfo' : $scope = 'snsapi_base';

        return 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $appid . '&redirect_uri=' . urlencode($url) . '&response_type=code&scope=' . $scope . '&state=' . $state . '#wechat_redirect';
    }


    //发送短信
    public static function sendMessage($phone, $code)
    {
        $ch = curl_init();
        $post_data = array(
            "account" => "sdk_zjbyt",
            "password" => "20151116",
            "destmobile" => $phone,
            "msgText" => "【诚信有礼】您的验证码是：" . $code . "。请及时输入，切勿泄露！",
            "sendDateTime" => "",
        );
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //这里原来是0，我改成1后，才能接收回调
        $post_data = http_build_query($post_data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_URL, 'http://www.jianzhou.sh.cn/JianzhouSMSWSServer/http/sendBatchMessage');
        curl_exec($ch);

        //大于0就是发送成功，小于0就是发送失败
        return curl_multi_getcontent($ch); //接收上面的回调信息，是字符串
    }

}
