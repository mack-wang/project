<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>浙江市场精品三代全新上市</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="精品三代——时光焕新，不忘初心">
    <meta name="Keywords" content="精品三代——时光焕新，不忘初心">
    <meta property="og:description" content="精品三代——时光焕新，不忘初心">

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="{{asset('plugin/h5/sandai_h5/css/swiper.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/h5/sandai_h5/css/animate.min.css')}}">
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
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
                "imgUrl": "http://www.boyuantang.com/airport/public/plugin/h5/sandai_h5/img/header.png",//分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                "desc": "精品三代——时光焕新，不忘初心",//摘要,如果分享到朋友圈的话，不显示摘要。
                "title": '浙江市场精品三代全新上市',//分享卡片标题
                "link": window.location.href,//分享出去后的链接，这里可以将链接设置为另一个页面。
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
    <!-- Demo styles -->
    <style>
        html, body {
            position: relative;
            height: 100%;
        }

        body {
            background: #eee;
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .swiper-container {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background-image: url("{{asset('plugin/h5/sandai_h5/img/2/bg-all.png')}}");
            background-size: 100% 100%;
            position: relative;
            /* Center slide text vertically */
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
        }

        .ab {
            position: absolute;
        }

        .w1 {
            width: 10%;
        }

        .w2 {
            width: 20%;
        }

        .w3 {
            width: 30%;
        }

        .w4 {
            width: 40%;
        }

        .w5 {
            width: 50%;
        }

        .w6 {
            width: 60%;
        }

        .w7 {
            width: 70%;
        }

        .w8 {
            width: 80%;
        }

        .w9 {
            width: 90%;
        }

        .w10 {
            width: 100%;
        }

        .myfade {
            animation: myfade 2s ease 1s infinite normal running
        }

        @keyframes myfade {
            0% {
                opacity: 0.3
            }
            50% {
                opacity: 0.9
            }
            100% {
                opacity: 0.3
            }
        }

        .mama {
            top: 0;
            left: 25%;
            float: left;
        }

        .ciga {
            width: 44%;
            bottom: 12%;
            left: 28%
        }

        @media (device-height: 480px) and (-webkit-min-device-pixel-ratio: 2) {
            /* 兼容iphone4/4s */
            .ciga {
                width: 40%;
                bottom: 12%;
                left: 30%
            }

            .mama {
                top: 0;
                left: 25%;
                float: left;
            }
        }
    </style>
</head>
<body>

<!-- Swiper -->
<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide first">
            <img src="{{asset('plugin/h5/sandai_h5/img/header.png')}}" style="display: none;" alt="">
            <p style="display: none;">精品三代——时光焕新，不忘初心。</p>
            <audio id="mama" src="{{asset('plugin/h5/sandai_h5/music/1.mp3')}}" autoplay preload loop="loop"></audio>
            <img id="music_btn" class="ab" src="{{asset('plugin/h5/sandai_h5/img/1/voice-o.png')}}" alt=""
                 style="top: 5%;right: 5%;width: 24px;">
            <div style="position: relative;width: 90%;top: 0;left: 0;text-align: start;padding-bottom: 300px;">
                <img class="ab w10" src="{{asset('plugin/h5/sandai_h5/img/1/planet.png')}}">
                <img class="ab w7 ani"
                     swiper-animate-effect="bounceIn"
                     swiper-animate-duration="1s"
                     src="{{asset('plugin/h5/sandai_h5/img/2/light.png')}}" alt="" style="bottom:18%;left:10%">
                <img class="ab w6 ani"
                     swiper-animate-effect="bounceIn"
                     swiper-animate-duration="1s"
                     src="{{asset('plugin/h5/sandai_h5/img/1/bai.png')}}" style="top: 30%;left: 20%">
                <img class="ab w4 ani"
                     swiper-animate-effect="bounceIn"
                     swiper-animate-duration="1s"
                     src="{{asset('plugin/h5/sandai_h5/img/1/you.png')}}" style="top: 50%;left: 30%">
                <img class="ab w9 ani"
                     swiper-animate-effect="bounceIn"
                     swiper-animate-duration="1s"
                     src="{{asset('plugin/h5/sandai_h5/img/1/jin.png')}}" alt="" style="bottom: 5%;left: 5%">
            </div>
        </div>
        <div class="swiper-slide eighth">
            <img class="ab w10 myfade" src="{{asset('plugin/h5/sandai_h5/img/8/circle.png')}}" alt=""
                 style="bottom:14%;left:0">
            <img class="ab w5 ani ciga"
                 swiper-animate-effect="fadeIn"
                 swiper-animate-duration="0.6s"
                 src="{{asset('plugin/h5/sandai_h5/img/8/ciga.png')}}" style="">
            <img class="ab w6 " src="{{asset('plugin/h5/sandai_h5/img/8/one.png')}}" style="top: 10%;left: 20%">
            <img class="ab w9 " src="{{asset('plugin/h5/sandai_h5/img/8/bai.png')}}" alt="" style="bottom: 5%;left: 5%">
        </div>
        <div class="swiper-slide second">
            <img class="ab w10 ani"
                 swiper-animate-effect="slideInUp"
                 swiper-animate-duration="0.5s"
                 src="{{asset('plugin/h5/sandai_h5/img/2/bg-1.png')}}" alt="" style="bottom:0;left:0">
            <img class="ab w2 ani"
                 swiper-animate-effect="slideInRight"
                 swiper-animate-duration="0.5s"
                 src="{{asset('plugin/h5/sandai_h5/img/2/new-tech.png')}}" alt="" style="top:8%;right:50px">
            <img class="ab w6 ani"
                 swiper-animate-effect="slideInRight"
                 swiper-animate-duration="0.5s"
                 src="{{asset('plugin/h5/sandai_h5/img/2/shuai.png')}}" alt="" style="top:25%;right:50px">
            <img class="ab w7 ani"
                 swiper-animate-effect="slideInRight"
                 swiper-animate-duration="0.5s"
                 src="{{asset('plugin/h5/sandai_h5/img/2/light.png')}}" alt="" style="top:32%;right:50px">
            <img class="ab w5 ani"
                 swiper-animate-effect="slideInRight"
                 swiper-animate-duration="0.5s"
                 src="{{asset('plugin/h5/sandai_h5/img/2/kong.png')}}" alt="" style="top:30%;right:50px">
        </div>
        <div class="swiper-slide third">
            <img class="ab w5" src="{{asset('plugin/h5/sandai_h5/img/3/cloud1.png')}}" alt=""
                 style="top:10%;left:0;opacity: 0.8">
            <img class="ab w5" src="{{asset('plugin/h5/sandai_h5/img/3/cloud2.png')}}" alt=""
                 style="bottom:10%;right:0">
            <img class="ab w10" src="{{asset('plugin/h5/sandai_h5/img/3/cloud3.png')}}" alt=""
                 style="bottom:0;right:0;">
            <img class="ab w2 ani"
                 swiper-animate-effect="slideInRight"
                 swiper-animate-duration="0.5s"
                 src="{{asset('plugin/h5/sandai_h5/img/3/new-matrial.png')}}" alt="" style="top:8%;right:50px">
            <img class="ab w7 ani"
                 swiper-animate-effect="slideInUp"
                 swiper-animate-duration="0.5s"
                 src="{{asset('plugin/h5/sandai_h5/img/3/plant.png')}}" alt="" style="bottom:-5%;left:10%">
            <img class="ab w6 ani"
                 swiper-animate-effect="slideInRight"
                 swiper-animate-duration="0.5s"
                 src="{{asset('plugin/h5/sandai_h5/img/3/du.png')}}" alt="" style="top:25%;right:50px">
            <img class="ab w7 ani"
                 swiper-animate-effect="slideInRight"
                 swiper-animate-duration="0.5s"
                 src="{{asset('plugin/h5/sandai_h5/img/2/light.png')}}" alt="" style="top:30%;right:50px">
            <img class="ab w7 ani"
                 swiper-animate-effect="slideInRight"
                 swiper-animate-duration="0.5s"
                 src="{{asset('plugin/h5/sandai_h5/img/3/san.png')}}" alt="" style="top:30%;right:50px">
        </div>
        <div class="swiper-slide fourth">

            <div style="position: relative;width: 90%;top: 0;left: 0;text-align: start;padding-bottom: 300px;">
                <img class="ab w10 ani"
                     swiper-animate-effect="rotateIn"
                     swiper-animate-duration="5s"
                     src="{{asset('plugin/h5/sandai_h5/img/4/circle1.png')}}" alt="" style="">
                <img class="ab w10 ani"
                     swiper-animate-effect="rotateIn"
                     swiper-animate-duration="1s"
                     src="{{asset('plugin/h5/sandai_h5/img/4/circle2.png')}}" alt="" style="">
                <img class="ab w10 ani"
                     swiper-animate-effect="rotateIn"
                     swiper-animate-duration="2s" src="{{asset('plugin/h5/sandai_h5/img/4/circle3.png')}}" alt=""
                     style="">
                <img class="ab w10 ani"
                     swiper-animate-effect="rotateIn"
                     swiper-animate-duration="9s" src="{{asset('plugin/h5/sandai_h5/img/4/circle4.png')}}" alt=""
                     style="">
                <img class="ab w10 ani"
                     swiper-animate-effect="rotateIn"
                     swiper-animate-duration="10s"
                     src="{{asset('plugin/h5/sandai_h5/img/4/circle5.png')}}" alt="" style="">
                <img class="ab w10 ani"
                     swiper-animate-effect="rotateIn"
                     swiper-animate-duration="1s"
                     src="{{asset('plugin/h5/sandai_h5/img/4/circle6.png')}}" alt="" style="">
                <img class="ab w6" src="{{asset('plugin/h5/sandai_h5/img/4/jin.png')}}" alt=""
                     style="top: 30%;left: 20%">
                <img class="ab w8" src="{{asset('plugin/h5/sandai_h5/img/4/zhuang.png')}}" alt=""
                     style="top: 50%;left: 10%">
                <img class="ab w8" src="{{asset('plugin/h5/sandai_h5/img/4/an.png')}}" alt=""
                     style="top: 60%;left: 10%">

            </div>
            <img class="ab w5 mama ani"
                 swiper-animate-effect="slideInDown"
                 swiper-animate-duration="1s"
                 src="{{asset('plugin/h5/sandai_h5/img/8/mama.png')}}" alt="">


        </div>
        <div class="swiper-slide fifth">
            <img class="ab w3 " src="{{asset('plugin/h5/sandai_h5/img/5/gift.png')}}" alt="" style="top:9%;left:10%;">
            <img class="ab w4 " src="{{asset('plugin/h5/sandai_h5/img/5/100.png')}}" alt="" style="top:12%;left:50%;">
            <img class="ab w7" src="{{asset('plugin/h5/sandai_h5/img/5/prize.png')}}" alt=""
                 style="bottom:5%;left:15%;">
        </div>
        <div class="swiper-slide sixth" style="background-image: url('{{asset('plugin/h5/sandai_h5/img/6/bg2.png')}}')">
            <img class="ab w9" src="{{asset('plugin/h5/sandai_h5/img/6/ling3.png')}}" alt="" style="top:10%;left: 6%;">
            <img class="ab w9" src="{{asset('plugin/h5/sandai_h5/img/6/xiao.png')}}" alt="" style="top:50%;left: 6%;">
        </div>
        <div class="swiper-slide seventh"
             style="background-image: url('{{asset('plugin/h5/sandai_h5/img/7/man.png')}}')">
            <img class="ab" src="{{asset('plugin/h5/sandai_h5/img/7/man2.png')}}" alt=""
                 style="width:26%;bottom:0;left: 38%;">
            <img class="ab w8 ani"
                 swiper-animate-effect="slideInDown"
                 swiper-animate-duration="1s"
                 src="{{asset('plugin/h5/sandai_h5/img/7/forget.png')}}" style="top:20%;left: 10%;">
        </div>
        <div class="swiper-slide ninth"
             style="background-image: url('{{asset('plugin/h5/sandai_h5/img/8/duangwu.png')}}')">
        </div>

    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
</div>

<!-- Swiper JS -->
<script src="{{asset('plugin/h5/sandai_h5/js/swiper.min.js')}}"></script>
<script src="{{asset('plugin/h5/sandai_h5/js/animate.min.js')}}"></script>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper('.swiper-container', {
        paginationClickable: true,
        direction: 'vertical',
        onInit: function (swiper) { //Swiper2.x的初始化是onFirstInit
            swiperAnimateCache(swiper); //隐藏动画元素
            swiperAnimate(swiper); //初始化完成开始动画
        },
        onSlideChangeEnd: function (swiper) {
            swiperAnimate(swiper); //每个slide切换结束时也运行当前slide动画
        }
    });

    var music_btn = document.getElementById("music_btn");
    music_btn.onclick = function () {
        var music = document.getElementById("mama");
        if (music.paused) {
            music.play();
            music_btn.setAttribute("src", "{{asset('plugin/h5/sandai_h5/img/1/voice-o.png')}}");
        } else {
            music.pause();
            music_btn.setAttribute("src", "{{asset('plugin/h5/sandai_h5/img/1/voice-c.png')}}");
        }
    };

    function audioAutoPlay(id) {
        var audio = document.getElementById(id);
        audio.play();
        document.addEventListener("WeixinJSBridgeReady", function () {
            audio.play();
        }, false);
        document.addEventListener('YixinJSBridgeReady', function () {
            audio.play();
        }, false);
    }
    audioAutoPlay('mama');
</script>
</body>
</html>
