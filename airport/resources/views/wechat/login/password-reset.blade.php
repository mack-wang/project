@extends('wechat.layout.frame',['title' => "密码重置"])
@section('content')
    <body style="background: url('{{asset('img/wechat/login-bg.jpg')}}') no-repeat;background-size:100% 100%;">
    <div class="ui container" style="padding:20px;padding-top: 120px;">
        <form method="POST" action="{{url('wechat/password-reset')}}" class="ui form user" style="font-size: 16px;">
            <div class="field">
                <div class="ui left icon input">
                    <input type="password" name="password" placeholder="请输入新密码" value="{{old('password')}}">
                    <i class="lock icon"></i>
                </div>
            </div>
            <div class="field">
                <div class="ui left icon input">
                    <input type="text" name="phone" placeholder="请输入手机号" value="{{old('phone')}}">
                    <i class="mobile icon"></i>
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
            <input id="test1" class="ui fluid green button" style="margin-top: 20px" type="submit" value="登入">
        </form>

        {{--接收响应信息--}}
        @include('wechat.layout.message')
    </div>

    @include('wechat.layout.agreement')

@endsection