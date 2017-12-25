@extends('wechat.layout.frame',['title' => "登入"])
@section('content')
    <body style="background: url('{{asset('img/wechat/login-bg.jpg')}}') no-repeat;background-size:100% 100%;">
    <div class="ui container" style="padding:20px;padding-top: 120px;">
        <form method="POST" action="{{url('wechat/password-login')}}" class="ui form user" style="font-size: 16px;">
            <div class="field">
                <div class="ui left icon input">
                    <input type="password" name="password" placeholder="请输入密码" value="{{old('password')}}">
                    <i class="lock icon"></i>
                </div>
            </div>
            <a href="{{url('wechat/login/view/password-reset')}}">忘记密码</a>
            <input id="test1" class="ui fluid green button" style="margin-top: 20px" type="submit" value="登入">
        </form>

        {{--接收响应信息--}}
        @include('wechat.layout.message')
    </div>

    <div class="ui info modal"></div>

    </body>

@endsection