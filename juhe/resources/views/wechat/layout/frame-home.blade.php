<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>钜合天下</title>
    <meta name="domain" content="{{ url('wechat') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/semantic.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('font/juhe/juhe.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/basic.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/swiper-3.4.2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/semantic.min.js')}}"></script>
    <script src="{{asset('js/jquery.yu.js')}}"></script>
    <script src="{{asset('js/swiper-3.4.2.min.js')}}"></script>
    {{--微信分享设置--}}
    <script src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script>
        wx.config(@php
            echo $js->config(array(
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo'
            ), false)
        @endphp
        );
    </script>
    <script>

        window.share_config = {
            "share": {
                "imgUrl": "{{url($wechat->imgUrl)}}",//分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                "desc": "{{$wechat->description}}",//摘要,如果分享到朋友圈的话，不显示摘要。
                "title": "{{$wechat->title}}",//分享卡片标题
                "link": "{{$link or $wechat->link}}",//分享出去后的链接，这里可以将链接设置为另一个页面。
                "success": function () {//分享成功后的回调函数
                },
                'cancel': function () {
                    // 用户取消分享后执行的回调函数
                }
            }
        };

        wx.ready(function () {
            wx.onMenuShareAppMessage(share_config.share);//分享给好友
            wx.onMenuShareTimeline(share_config.share);//分享到朋友圈
            wx.onMenuShareQQ(share_config.share);//分享给手机QQ
        });

    </script>
</head>
<body style="height: 100%;overflow-x:hidden;}">
@yield('content')
<div style="height: 60px;">
</div>
<div class="ui fluid fixed sticky bottom mini borderless labeled icon five item menu app">
    <a href="{{url('wechat/home')}}" class="item" target="main">
        <i class="home icon"></i>
        首页
    </a>
    <a href="{{url('wechat/product')}}" class="item" target="main">
        <i class="shop icon"></i>
        产品
    </a>
    <a href="{{url('wechat/connect')}}" class="item" target="main">
        <i class="phone icon"></i>
        团购热线
    </a>
    <a href="{{url('wechat/company')}}" class="item" target="main">
        <i class="block layout icon"></i>
        合作伙伴
    </a>
    <a href="{{url('/home')}}" class="item" target="main">
        <i class="user icon"></i>
        我
    </a>
</div>
</body>
<script src="{{asset('js/basic.js')}}"></script>
<script src="{{asset('js/wechat.js')}}"></script>
</html>