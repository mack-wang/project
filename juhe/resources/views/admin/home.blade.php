@extends('admin.layout.home-frame')
@section('content')
    <body class="relative" style="overflow: hidden;">
    <!-- 导航菜单 -->
    <div class="ui fixed inverted menu">
        <div class="ui container">
            <a href="#" class="header item">
                <i class="ui huge yu-juhe icon" style="margin: -20px auto"></i>
                聚合团购管理后台
            </a>
            <div class="ui simple dropdown item">
                快速导航 <i class="dropdown icon"></i>
                <div class="menu">
                    <a href="{{url('admin/product/show/editArticle')}}" class="item" target="main">编辑文章</a>
                    <a href="{{url('admin/index/show/headline')}}" class="item" target="main">钜合头条</a>
                    <a href="{{url('admin/connect/index')}}" class="item" target="main">编辑热线</a>
                </div>
            </div>
            <a href="#" class="right item">您好，{{Auth::guard('admin')->user()->name}}</a>
            <a href="{{url('admin/logout')}}" class="item">退出</a>
        </div>
    </div>

    <div class="ui main container" style="margin-top: 45px;height: 100%;">
        <div class="ui two column grid" style="height: 100%;overflow: hidden;">
            <div class="two wide column">
                <div class="ui vertical menu clear-shadow clear-radio home">
                    <div class="item">
                        <div class="header">首页</div>
                        <div class="menu">
                            <a href="{{url('admin/index/show/nav')}}" class="item" target="main">轮播图</a>
                            <a href="{{url('admin/index/show/headline')}}" class="item" target="main">钜合头条</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="header">产品</div>
                        <div class="menu">
                            <a href="{{url('admin/product/show/article')}}" class="item" target="main">文章</a>
                            <a href="{{url('admin/product/show/editArticle')}}" class="item" target="main">编辑文章</a>
                            <a href="{{url('admin/product/show/catalog')}}" class="item" target="main">目录</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="header">企业</div>
                        <div class="menu">
                            <a href="{{url('admin/connect/index')}}" class="item" target="main">服务热线</a>
                            <a href="{{url('admin/company/index')}}" class="item" target="main">企业介绍</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="header">微信</div>
                        <div class="menu">
                            <a href="{{url('admin/wechat/index')}}" class="item" target="main">微信分享设置</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="header">用户</div>
                        <div class="menu">
                            <a href="{{url('admin/user/index')}}" class="item" target="main">所有注册用户</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="header">管理员</div>
                        <div class="menu">
                            <a href="{{url('admin/reset/password')}}" class="item" target="main">修改密码</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="fourteen wide column">
                <iframe src="{{url('admin/index/show/nav')}}" frameborder="0" width="100%" height="100%"
                        name="main"></iframe>
            </div>
        </div>

    </div>

    {{--<div class="ui vertical footer segment" style="position: absolute;left: 0;bottom: 0;width: 100%;background-color: white;border-top: 1px solid #ddd;">--}}
        {{--<div class="ui center aligned container">--}}
            {{--<div class="ui horizontal small divided link list">--}}
                {{--<a class="item" href="#" style="color:black;">备案/许可证编号为：浙ICP备17026678号</a>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}


    </body>
    <script>
        //激活下拉菜单
        $('.ui.dropdown').dropdown();
        //激活手风琴式菜单
        $('.ui.accordion').accordion();
    </script>
@endsection