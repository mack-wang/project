<?php

namespace App\Http\Controllers;

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

        $wechat->server->setMessageHandler(function ($message) {
            return "欢迎关注钜合团购！";
        });

        $menu = $wechat->menu;
        $buttons = [
            [
                "type" => "view",
                "name" => "钜合团购",
                "url" => "https://www.juhetuangou.com/wechat/home",
            ],
            [
                "type" => "view",
                "name" => "联系方式",
                "url" => "https://www.juhetuangou.com/wechat/connect",
            ],
        ];
        $menu->add($buttons);

        $wechat->server->setMessageHandler(function ($message) {
            switch ($message->MsgType) {
                case 'text':
                    return '已经收到您的文字';
                    break;
                case 'image':
                    return '已经收到您的图片';
                    break;
                case 'voice':
                    return '已经收到您的语音';
                    break;
                case 'video':
                    return '已经收到您的视频';
                    break;
                case 'location':
                    return '已经收到您的坐标';
                    break;
                case 'link':
                    return '已经收到您的链接';
                    break;
                // ... 其它消息
                default:
                    return '终于等到您啦，感谢您关注钜合天下！

我们专注于粮油、食品、酒水等快消行业批发、团购；解决企事业单位、机关、学校的大宗商品物资供应、福利团购、联合促销等业务。

想要了解产品信息，<a href="https://www.juhetuangou.com/wechat/product">点击这里，了解我们</a>

想要成为我们的合作伙伴，<a href="https://www.juhetuangou.com/wechat/company">点击这里，了解合作伙伴计划</a>

<a href="https://www.juhetuangou.com/wechat/home">新鲜资讯，快戳这里</a>';
                    break;
            }
        });

        return $wechat->server->serve();
    }


}
