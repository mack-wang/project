@extends('wechat.layout.frame',['title' => "注册"])
@section('content')
    <body style="background: url('{{asset('img/wechat/login-bg.jpg')}}') no-repeat;background-size:100% 100%;">
    <div class="ui container" style="padding:20px;padding-top: 120px;">
        <form method="POST" action="{{url('wechat/login')}}" class="ui form user" style="font-size: 16px;">
            <div class="field">
                <div class="ui left icon input">
                    <input type="text" name="phone" placeholder="请输入手机号" value="{{old('phone')}}">
                    <i class="mobile icon"></i>
                </div>
            </div>
            <div class="field">
                <div class="ui left icon input">
                    <input type="password" name="password" placeholder="请设置密码" value="{{old('password')}}">
                    <i class="lock icon"></i>
                </div>
            </div>
            <div class="field">
                <div class="ui left icon right action input">
                    <input type="text" name="code" placeholder="输入短信验证码" value="{{old('code')}}" style="width:70%;">
                    <i class="qrcode icon"></i>
                    <a id="get-code" class="ui green button" style="width:30%;">
                        获取
                    </a>
                </div>
            </div>
            <div class="field" style="font-size: 14px">
                <div class="ui agreement checkbox" style="padding-top: 3px">
                    <input type="checkbox" tabindex="0" class="hidden">
                </div>
                <span>确认已经阅读并同意</span><a id="showAgreement">用户协议</a>
            </div>
            <input id="test1" class="ui fluid green button" style="margin-top: 20px" type="submit" value="登入">
            <div class="ui error message"></div>
        </form>

        {{--接收响应信息--}}
        @include('wechat.layout.message')
    </div>

    <div class="ui warning modal">
        <div class="ui green header">提醒</div>
        <div class="content">
            <p style="font-size: 20px;color:#00833d">请确认已经阅读并同意用户协议！</p>
        </div>
        <div class="actions">
            <div class="ui green approve button">确认</div>
            <div class="ui cancel button">退出</div>
        </div>
    </div>

    @include('wechat.layout.agreement')

    <div class="ui info modal"></div>

    </body>

@endsection