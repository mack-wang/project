@extends('wechat.layout.frame')
@section('content')
    <style>
        .line > div {
            color: gray;
        }
    </style>
    <body style="margin: 0;padding: 0">

    <div class="ui grid" style="margin: 0;padding: 0">
        <div class="sixteen wide tablet only mobile only column" style="margin: 0;padding: 0">
            <img class="ui image" src="{{asset('img/header.png')}}" alt="">
        </div>
        <div class="sixteen wide tablet only mobile only column" style="margin: 0;padding: 0">
            <div class="ui segment" style="padding:6px;">
                <div class="ui feed">
                    <div class="event">
                        <div class="label" style="width: 50px;padding-top: 4px;">
                            <img class="ui  image" src="{{asset('img/tom.png')}}">
                        </div>
                        <div class="content">
                            <div class="summary">
                                <label for="" class="ui tiny green circular label">等级</label>
                                <div class="ui star rating test" data-rating="1" data-max-rating="5"></div>
                                <span style="color:#00833d">菜鸟</span>
                            </div>
                            <div class="summary" style="padding-top: 4px">
                                <label for="" class="ui tiny green circular label">经验</label>
                                <div class="ui tiny green indicating progress m0"
                                     style="width: 30%;display: inline-block"
                                     data-value="16" data-total="20"
                                >
                                    <div class="bar"></div>
                                </div>
                                <span class="label inline" style="color:#00833d">300点</span>
                            </div>
                        </div>
                        <a href="{{url('wechat/apply/1')}}" class="ui compact green button fr" style="height: 30px;margin-top: 16px; ">
                            个人中心
                        </a>

                    </div>
                </div>
            </div>
        </div>


        <div class="sixteen wide tablet only mobile only column" style="margin: 0;padding: 0">
            <div class="ui segment" style="padding:6px;">
                <div class="ui feed">
                    <div class="event">
                        <div class="content">
                            <div class="summary" style="margin: 16px 0 0 16px;">
                                <span style="color:#00833d;">酷，今天的种草经验又 +15点</span>
                            </div>
                        </div>
                        <div class="label" style="width: 50px;padding-top: 4px;">
                            <img class="ui image" src="{{asset('img/wechat/grass2.png')}}">
                        </div>
                        <a href="{{url('wechat/apply/2')}}" class="ui compact green button fr"
                             style="height: 30px;margin-top: 16px;margin-left: 20px;">
                            点击收取
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div class="sixteen wide tablet only mobile only column" style="margin: 0;padding: 0">
            <div class="ui segment" style="padding:6px;">
                <div class="ui horizontal grid" style="margin: 0;padding: 0">
                    <div class="five wide column" style="margin: 8px;padding: 0">
                        <img class="ui image" src="{{asset('img/wechat/frw.png')}}" style="width: 110px;height: 110px;">
                    </div>
                    <div class="ten wide column" style="margin: 0;padding: 0;margin-top: 6px">
                        <div class="content">
                            <div class="summary line">
                                <div style="color:#00833d;font-weight: bold;">芙蓉王推出首款细支烟——芙蓉王硬闪带细支（菜鸟福利）</div>
                                <div>正在进行中</div>
                                <div>数量：50包 市场价：40元/包</div>
                                <div><i class="ui green hourglass half icon"></i>
                                    申领倒计时：<span style="color:#00833d;">3天2小时<span class="downtime2">19</span>分</span>
                                </div>
                                <div><i class="ui green user icon"></i>
                                    当前申领测评人数：<span style="color:#00833d;">205人</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="sixteen wide column" style="margin: 0;padding: 0;text-align: center;">
                        <div class="ui divider" style="margin-bottom: 6px;"></div>
                        <a class="" href="{{url('wechat/apply/3')}}" style="color:#00833d;display: inline-block;margin-bottom: 6px;">立即申领</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="sixteen wide tablet only mobile only column" style="margin: 0;padding: 0">
            <div class="ui segment" style="padding:6px;">
                <div class="ui horizontal grid" style="margin: 0;padding: 0">
                    <div class="five wide column" style="margin: 8px;padding: 0">
                        <img class="ui image" src="{{asset('img/wechat/txh.png')}}" style="width: 110px;height: 110px;">
                    </div>
                    <div class="ten wide column" style="margin: 0;padding: 0;margin-top: 6px">
                        <div class="content">
                            <div class="summary line">
                                <div style="color:#00833d;font-weight: bold;">拾岁辛勤耕耘，今日欢笑收获——和天下回馈体验测评（今日开启秒杀）</div>
                                <div>正在进行中</div>
                                <div>数量：50包 市场价：40元/包</div>
                                <div><i class="ui green hourglass half icon"></i>
                                    秒杀倒计时：<span style="color:#00833d;">2小时<span class="downtime1">19</span>分</span>
                                </div>
                                <div><i class="ui green wait icon"></i>
                                    秒杀开启时间：<span style="color:#00833d;">今日19:30</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="sixteen wide column" style="margin: 0;padding: 0;text-align: center;">
                        <div class="ui divider" style="margin-bottom: 6px;"></div>
                        <a class="" href="{{url('wechat/apply/4')}}" style="color:#00833d;display: inline-block;margin-bottom: 6px;">立即申领</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="sixteen wide tablet only mobile only column" style="margin: 0;padding: 0">
            <div class="ui warning modal">
                <img class="ui center-block tiny image m8" src="{{asset('img/warning.png')}}" alt=""/>
                <div class="ui divider"></div>
                <div class="content">
                    <p style="font-size: 20px;color:#00833d">本页面含有烟草信息，如果您未满18周岁，敬请回避！</p>
                </div>
                <div class="actions">
                    <div class="ui green approve button">确认</div>
                    <div class="ui cancel button">退出</div>
                </div>
            </div>
        </div>
    </div>


    </body>
    <script>
        //激活下拉菜单
        $('.ui.dropdown').dropdown();
        //激活手风琴式菜单
        $('.ui.accordion').accordion();

        if (!$.yu.getCookie('warning')) {
            $('.ui.warning.modal').modal('show');
            $.yu.setCookie('warning', 1);
        }

        $('.ui.star.rating').rating('disable');
        $('.ui.indicating.progress').progress('increment');
        var num = 19;
        setInterval(function () {
            num--;
            $('.downtime1').text(num);
            if (num == 0) num = 19;
        }, 1000);

        setInterval(function () {
            num--;
            $('.downtime2').text(num);
            if (num == 0) num = 19;
        }, 1000);

        var num2 = 0;
        setInterval(function () {
            num2++;
            $('.ui.star.rating.test').rating('set rating',num2);
            if (num2 == 5) num2 = 0;
        }, 1000);
    </script>
@endsection