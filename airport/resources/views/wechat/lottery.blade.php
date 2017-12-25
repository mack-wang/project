@extends('wechat.layout.frame',['title' => "幸运转盘"])
@section('content')
    <body style="margin: 0;padding: 0; overflow: hidden;">
    <audio id="music" src="{{asset('music/lottery.wav')}}" preload loop="loop"></audio>
    <img src="{{asset('img/lottery/bg.png')}}" style="position: absolute;left: 0;top: 0;width: 100%;"
         alt="">
    <div style="position: absolute;bottom: 15%;left:10%;width: 100%;text-align: center">
        <div style="position: relative;width: 80%;">
            <img src="{{asset('img/lottery/lottery.png')}}" style="width: 100%">
            <img id="rotatebg" src="{{asset('img/lottery/pointer.png')}}"
                 style="width:30%;position: absolute;left: 35%;top: 35%;">
        </div>
    </div>
    <div style="width: 100%;height: 60px;position: absolute;bottom: 2%;left: 0;text-align: center">
        <a href="{{url('wechat/home')}}" class="ui orange button" style="margin-right: 40px;">领取奖品</a>
        <a href="{{url('wechat/apply/list')}}" class="ui orange button">免费试用</a>
    </div>
    </body>
    <script>
        function setDegree($obj, deg) {
            $obj.css({
                'transform': 'rotate(' + deg + 'deg)',
                '-moz-transform': 'rotate(' + deg + 'deg)',
                '-o-transform': 'rotate(' + deg + 'deg)'
            });
        }

        function rotate($offset, $result) {
            var $tar = $('#rotatebg'),
                i,
                cnt = 100,                          //用做ratio的索引(10-29)
                total = 0,                          //记录上一次的变化结果
                ratio = [],                         //存放角度的变化比例，制造快慢过渡效果
                offset = $offset,     //0-5,逆时针数，代表需要停到的奖项,由后端传入
                amount = 18 - ( 0.3 * offset ),     //每次每多出60/200=0.3度,200次就多偏转60度
                result = $result; //奖项名称用于显示,由后端传入

            ratio[1] = [0.2, 0.4, 0.6, 0.8, 1, 1, 1.2, 1.4, 1.6, 1.8];
            ratio[2] = [1.8, 1.6, 1.4, 1.2, 1, 1, 0.8, 0.6, 0.4, 0.2];

            for (i = 0; i < 200; i++) {
                //设计为200次50ms的间隔，10s出结果感觉比较好
                setTimeout(function () {
                    //计算每次偏转增量，对应阶段的增减比例最终造成快慢变化
                    var deg = amount * ( ratio[String(cnt).substr(0, 1)][String(cnt).substr(1, 1)] );
                    setDegree($tar, deg + total);//改变偏转
                    total += deg;//记录
                    cnt++;//依据次数用作ratio的索引，这里用到了闭包不能使用i
                }, i * 50);
            }
            setTimeout(function () {
                $('#music')[0].pause();
                alert(result);//完成
            }, 200 * 50 + 500);
        }

        //绑定事件，点击指针开始
        $(function () {
            $("#rotatebg").click(function () {
                $.ajax({
                    type: 'GET',
                    url: "{{url("wechat/lottery/play")}}",
                    async: false,
                    success: function (data) {
                        if (data.shop) {
                            alert('您未绑定任务终端，无法参与抽奖！');
                            return false;
                        }

                        if (data.auth) {
                            alert('您已经参加过抽奖了，不可以重复参与！');
                            return false;
                        }
                        setTimeout(function () {
                            $('#music')[0].play();
                        }, 1);
                        rotate(data.offset, data.result);
                    },
                    dataType: 'json'
                });

            });
        });


    </script>
@endsection