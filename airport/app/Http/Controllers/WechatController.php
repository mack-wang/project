<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Wechat\Helper;
use App\Models\Shop;
use App\Models\User;
use EasyWeChat\Foundation\Application;

class WechatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        $wechat = app('wechat');

        $menu = $wechat->menu;
        $buttons = [
            [
                "type" => "view",
                "name" => "活动专区",
                "url" => "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx7066cfcf8f77f66f&redirect_uri=https%3A%2F%2Fwww.boyuantang.com%2Fwechat%2Fapply&response_type=code&scope=snsapi_base&state=0#wechat_redirect",
            ],
            [
                "type" => "view",
                "name" => "个人中心",
                "url" => "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx7066cfcf8f77f66f&redirect_uri=https%3A%2F%2Fwww.boyuantang.com%2Fwechat%2Fgohome&response_type=code&scope=snsapi_base&state=0#wechat_redirect",
            ],
        ];
        $menu->add($buttons);

        $wechat->server->setMessageHandler(function ($message) {
            switch ($message->MsgType) {
                case 'event':
                    switch ($message->Event) {
                        case 'subscribe'://订阅事件
                            $message->EventKey ? $shop_id = substr($message->EventKey, 8) : $shop_id = null;
                            $register = User::where('openid', $message->FromUserName)->first();
                            if ($register !== null && $register->shop_id !== null) {
                                //已经注册并绑定店铺，什么也不做
                            } elseif ($register !== null && $register->shop_id === null) {
                                //已经注册但未绑定店铺，进行绑定，有可能依旧是null
                                $register->shop_id = $shop_id;
                                $register->save();

                            }else{
                                User::create([
                                    'shop_id' => $shop_id,
                                    'openid' => $message->FromUserName,
                                    'register' => 2,
                                ]);
                            }

                            return '尊敬的阁下：
180秒的时间可以做什么？
84毫米的燃烧时间？
还是3分钟的趣味体验时光？
这里，有“幸运之礼”欢迎奔波的你，
这里，有“尝鲜体验”犒赏忙碌的你，
这里，有“专业鉴赏”恭候独到的你，
终于等到你，博烟荟萃<a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx7066cfcf8f77f66f&redirect_uri=https%3A%2F%2Fwww.boyuantang.com%2Fwechat%2Fapply&response_type=code&scope=snsapi_base&state=0#wechat_redirect">尽在这里</a>！
（因免费试用产品中涉及未成年人不可使用，请未满18岁人士回避。）
';
                            break;
                        case 'SCAN':
                            $shop_id = $message->EventKey;
                            $register = User::where('openid', $message->FromUserName)->first();
                            if ($register !== null && $register->shop_id !== null) {
                                //已经注册并绑定店铺
                            }elseif ($register !== null && $register->shop_id === null) {
                                //已经注册但未绑定店铺，进行绑定，有可能依旧是null
                                $register->shop_id = $shop_id;
                                $register->save();
                            }else{
                                User::create([
                                    'shop_id' => $shop_id,
                                    'openid' => $message->FromUserName,
                                    'register' => 2,
                                ]);
                            }
                            return '尊敬的阁下：
180秒的时间可以做什么？
84毫米的燃烧时间？
还是3分钟的趣味体验时光？
这里，有“幸运之礼”欢迎奔波的你，
这里，有“尝鲜体验”犒赏忙碌的你，
这里，有“专业鉴赏”恭候独到的你，
终于等到你，博烟荟萃<a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx7066cfcf8f77f66f&redirect_uri=https%3A%2F%2Fwww.boyuantang.com%2Fwechat%2Fapply&response_type=code&scope=snsapi_base&state=0#wechat_redirect">尽在这里</a>！
（因免费试用产品中涉及未成年人不可使用，请未满18岁人士回避。）
';
                            break;
                        default:
                            break;
                    }
                    break;
                case 'text':
                    return '已经收到你的消息';
                    break;
                case 'image':
                    return '已经收到你的图片';
                    break;
                case 'voice':
                    return '已经收到你的语音';
                    break;
                case 'video':
                    return '已经收到你的视频';
                    break;
                case 'location':
                    return '已经收到你的坐标';
                    break;
                case 'link':
                    return '已经收到你的链接';
                    break;
                // ... 其它消息
                default:
                    return '已经收到你的消息';
                    break;
            }
        });

        return $wechat->server->serve();
    }


}
