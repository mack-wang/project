@extends('admin.layout.frame')
@section('content')
    <body class="iframe-body">

    <!--页面标题-->
    <div class="ui header p14">添加终端</div>
    <!--页面标题end-->

    <div class="ui container m28">
        <form class="ui form">
            <div class="field">
                <label>店铺名字</label>
                <div class="field">
                    <input type="text" name="first-name" placeholder="姓">
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>所在地区</label>
                    <select class="ui search dropdown" name="area">
                        <option value="WY">Wyoming</option>
                    </select>
                </div>
                <div class="field"></div>
            </div>
            <div class="two fields">
                <div class="required field">
                    <label>用户名</label>
                    <div class="ui icon input">
                        <input type="text" placeholder="用户名">
                        <i class="user icon"></i>
                    </div>
                </div>
                <div class="required field">
                    <label>密码</label>
                    <div class="ui icon input">
                        <input type="password">
                        <i class="lock icon"></i>
                    </div>
                </div>
            </div>
            <h4 class="ui block top attached header">可选调查</h4>
            <div class="ui bottom attached secondary segment">
                <div class="grouped fields">
                    <label for="alone">你是好人吗？</label>
                    <div class="field">
                        <div class="ui radio checkbox checked">
                            <input type="radio" checked="" name="alone">
                            <label>是</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="alone">
                            <label>否</label>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="ui dividing header">设置</h4>
            <h5 class="ui header">隐私</h5>
            <div class="field">
                <div class="ui toggle checkbox">
                    <input type="radio" name="privacy">
                    <label>允许 <b>所有人</b> 查看我账号</label>
                </div>
            </div>
            <div class="field">
                <div class="ui toggle checkbox">
                    <input type="radio" name="privacy">
                    <label>只允许 <b>好友</b> 查看我账号</label>
                </div>
            </div>
            <h5 class="ui header">新闻订阅</h5>
            <div class="field">
                <div class="ui slider checkbox">
                    <input type="checkbox" name="top-posts">
                    <label>本周头条</label>
                </div>
            </div>
            <div class="field">
                <div class="ui slider checkbox">
                    <input type="checkbox" name="hot-deals">
                    <label>热点问题</label>
                </div>
            </div>
            <div class="ui hidden divider"></div>
            <div class="field">
                <div class="ui checkbox">
                    <input type="checkbox" name="hot-deals">
                    <label>同意 <a href="#">服务条款</a>。</label>
                </div>
            </div>
            <div class="ui error message">
                <div class="header">我们发现了一些问题</div>
            </div>
            <div class="ui submit button">注册</div>
        </form>
    </div>


    <div style="height: 200px;"></div>
    <script>
        //启动dropdown
        $('.ui.dropdown').dropdown();

        //启动手风琴式菜单
        $('.ui.accordion').accordion();

        //启动标签式菜单
        $('.menu .item').tab();
    </script>
    </body>
@endsection