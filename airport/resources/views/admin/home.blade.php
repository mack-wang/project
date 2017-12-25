@extends('admin.layout.home-frame')
@section('content')
    <body style="overflow: hidden;">
    <!-- 导航菜单 -->
    <div class="ui inverted grid">
        <div class="sixteen wide column">
            <div class="ui green fixed inverted menu clear-radio nav m0">
                <a href="#" class="item">
                    <i class="big plane icon"></i>
                </a>
                <a href="{{url('admin/analyze/user')}}" class="item" target="main">
                    <i class="large yu-home icon"></i>博烟荟管理后台
                </a>
                {{--<a href="#" class="item">--}}
                    {{--<i class="large yu-comment icon"></i>--}}
                    {{--<div class="ui red circular label m0">12</div>--}}
                {{--</a>--}}
                {{--<a href="#" class="item">--}}
                    {{--<i class="big yu-eye icon"></i>--}}
                    {{--<div class="ui red circular label m0">124</div>--}}
                {{--</a>--}}
                <div href="" class="ui dropdown item">
                    <i class="large list icon"></i><label for="">快速导航</label>
                    <div class="menu">
                        <a href="{{url('admin/shop')}}" class="item" target="main">所有终端</a>
                        <a href="{{url('admin/analyze/user')}}" class="item" target="main">用户分析</a>
                    </div>
                </div>
                <!--右侧-->
                <a href="{{url('admin/reset/password')}}" target="main" class="right floated item ">修改管理员密码</a>
                <a href="#" class="item">您好，{{ $admin or '' }}</a>
                <a class="item reduce-padding"><img class="ui circular image" width="24"
                                                    src="{{asset('img/wechat/default.png')}}"></a>
                <a href="{{url('admin/logout')}}" class="item">退出</a>
            </div>
        </div>

    </div>


    <div class="ui fluid sticky grid" style="height: 100%;overflow: hidden;margin-top: 12px;">
        <div class="two wide column p0 " style="background-color: #eee;border-right:1px solid #dbdbdb;">


            <div id="admin-menu" class="ui fluid vertical menu p0 clear-shadow clear-radio">
                <a href="{{url('admin/shop')}}" class="item" target="main">
                    终端
                    <div class="ui green label">{{$counts['shops']}}</div>
                </a>
                <a href="{{url('admin/manager')}}" class="item" target="main">
                    管理员
                    <div class="ui green label">{{$counts['managers']}}</div>
                </a>
                <a href="{{url('admin/user')}}" class="item" target="main">
                    用户
                    <div class="ui red label">{{$counts['users']}}</div>
                </a>
                <a href="{{url('admin/list')}}" class="item" target="main">
                    活动
                    <div class="ui red label">{{$counts['activityCount']}}</div>
                </a>
                <div class="ui dropdown item">
                    奖品管理
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <a href="{{url('admin/post/index')}}" class="item" target="main"><i class="ui edit icon"></i>邮寄奖品</a>
                        <a href="{{url('admin/prize/show')}}" class="item" target="main"><i class="ui add icon"></i>奖品</a>
                        <a href="{{url('admin/charge/index')}}" class="item" target="main"><i class="ui eye icon"></i>话费充值记录</a>
                    </div>
                </div>
                <div class="ui dropdown item">
                    活动管理
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <a href="{{url('admin/article/')}}" class="item" target="main"><i class="ui edit icon"></i>文章</a>
                        <a href="{{url('admin/product/index')}}" class="item" target="main"><i class="ui edit icon"></i>试用产品</a>
                        <a href="{{url('admin/activity/apply')}}" class="item" target="main"><i class="ui add icon"></i>测评活动</a>
                        <a href="{{url('admin/activity/kill')}}" class="item" target="main"><i class="ui add icon"></i>秒杀活动</a>
                        <a href="{{url('admin/activity/airport')}}" class="item" target="main"><i class="ui add icon"></i>机场活动</a>
                        <a href="{{url('admin/activity/shop')}}" class="item" target="main"><i class="ui add icon"></i>烟店活动</a>
                        <a href="{{url('admin/activity/task')}}" class="item" target="main"><i class="ui add icon"></i>任务</a>
                        <a href="{{url('admin/activity/question')}}" class="item" target="main"><i class="ui add icon"></i>问题</a>
                    </div>
                </div>
                <div class="ui dropdown item">
                    系统设置
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <a href="{{url('admin/activity/nav')}}" class="item" target="main"><i class="ui edit icon"></i>导航</a>

                        {{--<a href="{{url('admin/lottery/show')}}" class="item" target="main">转盘</a>--}}
                    </div>
                </div>
                <div class="ui dropdown item">
                    统计
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <a href="{{url('admin/analyze/user')}}" class="item" target="main">用户分析</a>
                        <a class="item undevelop">图文分析</a>
                        <a class="item undevelop">菜单分析</a>
                        <a class="item undevelop">消息分析</a>
                    </div>
                </div>
            </div>
        </div>
        <!--右侧内容容器-->
        <div class="fourteen wide  column p0">
            <iframe src="{{url('admin/shop')}}" frameborder="0" width="100%" height="100%" name="main"></iframe>
        </div>
    </div>


    </body>
    <script>
        //激活下拉菜单
        $('.ui.dropdown').dropdown();
        //激活手风琴式菜单
        $('.ui.accordion').accordion();
    </script>
@endsection